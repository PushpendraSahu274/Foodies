<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public function meal(){
        return $this->belongsTo(Meal::class, 'meal_id','id');
    }
}
