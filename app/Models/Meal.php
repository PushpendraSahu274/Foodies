<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    protected $guarded = []; //nothing to guard.
    protected $with = ['category'];
    //
    public function category(){
        return $this->belongsTo(MealCategory::class, 'meal_category_id', 'id');
    }
}
