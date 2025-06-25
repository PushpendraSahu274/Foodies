<?php

namespace App\Http\Controllers;

use App\Http\Requests\Meal\MealStoreRequest;
use App\Http\Requests\Meal\MealUpdateRequest;
use App\Jobs\ProcessMealCsv;
use App\Models\Meal;
use App\Models\MealCategory;
use App\Models\User;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class MealController extends Controller
{
    use UploadImageTrait;
    //
    public function index(Request $request)
    {
        $query = Meal::query();
        $meal_categories = MealCategory::where('status', 1)->get();

        if (Auth::user()->role == 'admin') {
            $meals = $query->get();
            $profile = User::where('role', 'admin')->first();
            return view('admin.meals.index', compact('meals', 'profile', 'meal_categories'));
        } else {
            $query = $query->where('is_available', '=', 1)->where('quantity', '>', 0);
            $meals = $query->get();
            $meals->map(function ($meal) {
                if ($meal->picture_path && $this->isImageExistsInLocal($meal->picture_path)) {
                    $meal->picture_path = $this->getLocalImageUrl($meal->picture_path);
                }
                return $meal;
            });
            return view('user.meals.index', compact('meals', 'meal_categories'));
        }
    }

    public function listing(Request $request)
    {
        $query = Meal::with('category');
        // Handle search input
        if ($searchValue = $request->input('search.value')) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('meals.title', 'LIKE', "%$searchValue%")
                    ->orWhere('meals.id', 'LIKE', "%$searchValue%")
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

            $picture_path = $meal->picture_path && $this->isImageExistsInLocal($meal->picture_path)
                ? '<img src="' . $this->getLocalImageUrl($meal->picture_path) . '" class="img-thumbnail" style="width: 70px; height: 70px;" alt="No Image">'
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
                $meal->category->category_name ?? 'NA',
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

        // if ($request->hasFile('photo')) {
        //     //upload cloudinary
        //     $file = $request->file('photo');
        //     $picture_path = $this->uploadToCloudinary($file, 'meal');
        //     $meal->picture_path = $picture_path;
        // }

        if ($request->hasFile('photo')) {
            //upload cloudinary
            $file = $request->file('photo');
            $picture_path = $this->uploadImageOnLocal($file, 'meal');
            $meal->picture_path = $picture_path;
        }

        $meal->save();

        //dispatch the command to send the email to customer
        Artisan::call('meals:notify-customers',['meal_id' => $meal->id]);
        
        return response()->json([
            'success' => true,
            'message' => 'Product added successfully!',
        ], 200);
    }

    public function update(MealUpdateRequest $request)
    {
        $meal = Meal::findOrFail($request->id);
        $meal->title = $request->title ?? $meal->title;
        $meal->description = $request->description ?? $meal->description;
        $meal->mrp = $request->price ?? $meal->mrp;
        $meal->discount_percentage = $request->discount ? round($request->discount, 2) : $meal->discount_percentage;
        $meal->meal_category_id = $request->meal_category_id ?? $meal->meal_category_id;
        $meal->quantity = $request->quantity ?? $meal->quantity;

        // Handle image upload
        // if ($request->hasFile('photo')) {
        //     // Delete old image if it exists
        //     if ($meal->picture_path && $this->isCloudinaryResourceExists($meal->picture_path)) {
        //         $this->deleteResourceFromCloudinary($meal->picture_path);
        //     }

        //     $file = $request->file('photo');
        //     $picture_path = $this->uploadToCloudinary($file, 'meal');
        //     $meal->picture_path = $picture_path;
        // }

        if ($request->hasFile('photo')) {
            // Delete old image if it exists
            if ($meal->picture_path && $this->isImageExistsInLocal($meal->picture_path)) {
                $this->deleteImageFromLocal($meal->picture_path);
            }

            $file = $request->file('photo');
            $picture_path = $this->uploadImageOnLocal($file, 'meal');
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

    public function customer_meal_ajax(Request $request)
    {
        // dd($request->all());
        $price = $request->price_filter;
        $meal_category_id = $request->category_filter;
        $stock_filter = $request->stock_filter;
        // dd($request->all());
        // $query = Meal::query();
        $query = Meal::select('meals.*', 'mc.*')
            ->leftJoin('meal_categories as mc', 'mc.id', '=', 'meals.meal_category_id');
        //search implementtaion

        if ($request->has('search') && trim($request->search) != '') {
            $query = $query->where(function ($q) use ($request) {
                return $q->where('title', 'LIKE', "%$request->search%");
                // ->orWhere('mc.category_name','LIKE',"%$request->search%");
            });
        }

        // price filter
        if ($price && $price != '') {
            $query = $query->where('mrp', '<=', $price);
        }

        //category filter
        if ($meal_category_id && $meal_category_id != '') {
            $query = $query->where('meal_category_id', '=', $meal_category_id);
        }

        if ($stock_filter !== null && $stock_filter != '') { //0 -> upcoming | 1 -> available
            $query = $query->where('is_available', '=', (int)$stock_filter);
        }
        $meals = $query->get(); //filter meals.
        // dd($meals);
        $meals->map(function ($meal) {
            if ($meal->picture_path && $this->isImageExistsInLocal($meal->picture_path)) {
                $meal->picture_path = $this->getLocalImageUrl($meal->picture_path);
            }
            return $meal;
        });
        $html = '';

        if ($meals->isEmpty()) {
            $html = '<div class="text-center py-5 col-12">
                    <img src="' . asset('images/meal/empty-meal.svg') . '" alt="Empty menu" width="160" class="mb-4">
                    <h4 class="text-danger fw-bold">Oops! Our kitchen’s still cooking.</h4>
                    <p class="text-muted">We haven’t added meals here yet — but we’re working on it. Please check back soon!</p>
                </div>';
        } else {
            foreach ($meals as $meal) {
                $html .= view('user.meals.partials.meal-card', compact('meal'))->render();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Product filtered successfully',
            'data' => [
                'html' => $html,
            ],
        ]);
    }

    // public function import(Request $request)
    // {

    //     $request->validate([
    //         'csv_file' => 'required|mimes:csv,txt',
    //     ]);

    //     try {

    //         $filename = uniqid() . '.' . $request->file('csv_file')->getClientOriginalExtension();

    //         // Store it manually in a permanent path
    //         $request->file('csv_file')->move(storage_path('app/uploads'), $filename);

    //         $fullPath = storage_path('app/uploads/' . $filename);

    //         // Dispatch job to process CSV
    //         ProcessMealCsv::dispatch($fullPath);

    //         return back()->with('message', 'Upload started. Meals will be processed in the background.');
    //     } catch (\Exception $e) {
    //         // DB::rollback();
    //         Log::error('Error occured while meal_csv uploading. ' . $e->getMessage());
    //         abort(500, 'Error while uploading the csv ' . $e->getMessage());
    //     }
    // }

   

    public function import(Request $request){
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt',
        ]);

        try {
            $filename = uniqid() . '.' . $request->file('csv_file')->getClientOriginalExtension();

            // Store the uploaded CSV
            $request->file('csv_file')->move(storage_path('app/uploads'), $filename);

            $fullPath = storage_path('app/uploads/' . $filename);

            $rows = file($fullPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            if (!$rows || count($rows) < 2) {
                return back()->withErrors(['csv_file' => 'CSV appears to be empty or invalid.']);
            }

            $headers = array_map('strtolower', str_getcsv(array_shift($rows))); // get and clean header row

            $payload = [];

            foreach ($rows as $index => $line) {
                $row = array_combine($headers, str_getcsv($line));

                if (!$row) {
                    continue; // skip malformed rows
                }

                $validator = Validator::make($row, [
                    'title' => 'required',
                    'meal_category_id' => 'required|exists:meal_categories,id',
                ]);

                if ($validator->fails()) {
                    Log::warning('Skipping invalid row at index ' . $index, $validator->errors()->toArray());
                    continue;
                }

                $payload[] = [
                    'title' => ucfirst($row['title']) . '_' . Str::random(3),
                    'description' => $row['description'] ?? 'Delicious meal!',
                    'meal_category_id' => $row['meal_category_id'],
                    'quantity' => (int) $row['quantity'],
                    'is_available' => (int) $row['is_available'],
                    'mrp' => (float) $row['mrp'],
                    'picture_path' => $row['picture_path'],
                    'discount_percentage' => (int) $row['discount_percentage'],
                    'best_seller' => (int) $row['best_seller'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            if (!empty($payload)) {
                Meal::insert($payload);
                return back()->with('message', 'Meals imported successfully.');
            } else {
                return back()->with('warning', 'No valid meals found in the CSV.');
            }
        } catch (\Exception $e) {
            Log::error('Error occurred while meal_csv uploading: ' . $e->getMessage());
            abort(500, 'Error while uploading the CSV: ' . $e->getMessage());
        }
    }
}
