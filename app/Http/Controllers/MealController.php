<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\User;
use Illuminate\Http\Request;

class MealController extends Controller
{
    //
    public function index(Request $request){
        $meals = Meal::get();
        $profile = User::where('role','admin')->first();
        return view('admin.meals.index',compact('meals','profile'));
    }


    public function listing(Request $request)
    {

        $query = Meal::query();
        // Handle search input
        if ($searchValue = $request->input('search.value')) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('meals.title', 'LIKE', "%$searchValue%")
                ->orWhere('meals.description','LIKE', "%$searchValue%");
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

            $picture_path = $meal->picture_path == null ? 'No Image' : '<img width="50" height="50" src="' . env("APP_URL") . $meal->picture_path . '"></img>';
            $action = '<a href="#" class="btn btn-sm btn-primary view-btn"
            data-head_id="' . htmlspecialchars($meal->id, ENT_QUOTES, 'UTF-8') . '">
            View <span><i class="la la-eye"></i></span>
        </a>';

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

}
