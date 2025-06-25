<?php

namespace App\Console\Commands\Meal;

use App\Mail\Meal\MealAdded;
use App\Models\Meal;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class sendMealNotification extends Command
{
   protected $signature = 'meals:notify-customers {meal_id}';
   protected $description = 'Send meal notification to all the customers about new added meal';

   public function handle(){
    $mealId = $this->argument('meal_id'); // i will rec

    //find the meal
    $meal = Meal::find($mealId);
    if(!$meal){
        $this->error('Meal Not Found !');
        return;
    }

    Log::info(asset('storage/'.$meal->picture_path));
    //meal found
    $this->info('sending notificatin for the meal '.$meal->title);

    $customers = User::where('role','user')->where('status',1)->where('email','pussusahu274@gmail.com')->cursor();

    //loop through the customers and send the email
    foreach($customers as $customer){
        //send the email
        Mail::to($customer->email)->queue(new MealAdded($meal)); // added in the queue

    }

    $this->info('Email queued for all the customers !');
   }
}
