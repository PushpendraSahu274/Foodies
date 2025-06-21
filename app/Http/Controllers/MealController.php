<?php

namespace App\Http\Controllers;

use App\Http\Requests\Meal\MealStoreRequest;
use App\Http\Requests\Meal\MealUpdateRequest;
use App\Models\Meal;
use App\Models\MealCategory;
use App\Models\User;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\CssSelector\XPath\Extension\FunctionExtension;

class MealController extends Controller
{
    use UploadImageTrait;
    //
    public function index(Request $request)
    {
        $query = Meal::query();
        $meal_categories = MealCategory::where('status', 1)->get();
        
        if(Auth::user()->role == 'admin'){
            $meals = $query->get();
            $profile = User::where('role', 'admin')->first();
            return view('admin.meals.index', compact('meals', 'profile', 'meal_categories'));
        }
        else{ 
            $query = $query->where('is_available','=',1)->where('quantity','>',0); 
            $meals = $query->get();
                return view('user.meals.index',compact('meals','meal_categories'));
        }
    }

    public function listing(Request $request)
    {
        $query = Meal::query();
        // Handle search input
        if ($searchValue = $request->input('search.value')) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('meals.title', 'LIKE', "%$searchValue%")
                    ->orWhere('meals.id','LIKE',"%$searchValue%")
                    ->orWhere('meals.description', 'LIKE', "%$searchValue%");
            });
        }

        $totalRecords = $query->count();

        $meals = $query->orderBy('meals.id', 'desc')
            ->offset($request->input('start', 0))
            ->limit($request->input('length', 10))
            ->get();

        $data = [];
        $sno = $request->input('start', 0) + 1;

        foreach ($meals as $meal) {

            $picture_path = $meal->picture_path && $this->isCloudinaryResourceExists($meal->picture_path) 
                            ? '<img src="'.$this->getCloudinaryResourceUrl($meal->picture_path).'" class="img-thumbnail" style="width: 70px; height: 70px;" alt="No Image">'
                            : '<img src="https://via.placeholder.com/150x150?text=No+Image" class="img-thumbnail" alt="No Image">';
            $editIcon = '<button type="button" 
                class="btn btn-link text-success p-0 me-2 edit-btn" 
                data-id="' . $meal->id . '">
                <i class="fa fa-pen"></i>
                </button>';
            $deleteIcon = '<button class="btn btn-outline-none delete-btn" data-id="' . $meal->id . '">
                  <i class="fa fa-trash text-danger"></i>
               </button>';
            $action = '<div class="d-flex align-items-center justify-content-around">'
                . $editIcon
                . $deleteIcon
                . '</div>';


            $data[] = [
                // $sno++,
                $meal->id,
                $meal->title,
                $meal->mrp,
                $meal->meal_category_id,
                $meal->discount_percentage,
                $meal->is_available,
                $picture_path,
                $meal->mrp,
                //$meal->meal_category_id, // quantity
                $action
            ];
        }

        // dd($data);
        return response()->json([
            'draw' => intval($request->input('draw', 1)),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data,
        ]);
    }

    public function store(MealStoreRequest $request)
    {
        $meal = new Meal();
        $meal->title = $request->title;
        $meal->description = $request->description;
        $meal->mrp = $request->price;
        $meal->discount_percentage = round($request->discount, 2);
        $meal->meal_category_id = $request->meal_category_id;
        $meal->quantity = $request->quantity;

        if ($request->hasFile('photo')) {
            //upload cloudinary
            $file = $request->file('photo');
            $picture_path = $this->uploadToCloudinary($file, 'meal');
            $meal->picture_path = $picture_path;
        }

        $meal->save();
        return response()->json([
            'success' => true,
            'message' => 'Product added successfully!',
        ], 200);
    }

    public function update(MealUpdateRequest $request){
        $meal = Meal::findOrFail($request->id);
        $meal->title = $request->title ?? $meal->title;
        $meal->description = $request->description ?? $meal->description;
        $meal->mrp = $request->price ?? $meal->mrp;
        $meal->discount_percentage = $request->discount ? round($request->discount, 2) : $meal->discount_percentage;
        $meal->meal_category_id = $request->meal_category_id ?? $meal->meal_category_id;
        $meal->quantity = $request->quantity ?? $meal->quantity;

        // Handle image upload
        if ($request->hasFile('photo')) {
            // Delete old image if it exists
            if ($meal->picture_path && Storage::disk('public')->exists($meal->picture_path)) {
                Storage::disk('public')->delete($meal->picture_path);
            }

            $file = $request->file('photo');
            $picture_path = $this->UploadImage($file, 'meal');
            $meal->picture_path = $picture_path;
        }

        $meal->save();

        return response()->json([
            'success' => true,
            'message' => 'Meal updated successfully!',
        ], 200);
    }

    public function destroy($id)
    {
        $meal = Meal::findOrFail($id);
        $meal->delete();
        return response()->json([
            'success' => true,
            'message' => 'Meal delete successfully',
        ], 200);
    }

    public function customer_meal_ajax(Request $request){   
        // dd($request->all());
        $price = $request->price_filter;
        $meal_category_id = $request->category_filter;
        $stock_filter = $request->stock_filter;

        $query = Meal::query();

        // price filter
        if($price && $price != ''){
            $query = $query->where('mrp','<=',$price);
        }

        //category filter
        if($meal_category_id && $meal_category_id != ''){
            $query = $query->where('meal_category_id','=',$meal_category_id);
        }
        
        if($stock_filter !== null && $stock_filter != ''){ //0 -> upcoming | 1 -> available
            $query = $query->where('is_available','=',(int)$stock_filter);
        }
        $meals = $query->get(); //filter meals.
        $html = '';

        foreach($meals as $meal){
        $html .= view('user.meals.partials.meal-card',compact('meal'))->render();
        }

        return response()->json([
            'success' => true,
            'message' => 'Product filtered successfully',
            'data' => [
                'html'=> $html,
            ],
        ]);
    }
}
