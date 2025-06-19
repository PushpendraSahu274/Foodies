<?php

namespace App\Observers\Meal;

use App\Models\Meal;
use Illuminate\Support\Facades\Storage;

class MealObserver
{
    //
    public function deleting(Meal $meal) {
        if($meal->profile_picture && Storage::disk('public')->exists($meal->profile_picture)){
            Storage::disk('public')->delete($meal->profile_picture);
        }
    }
}
