<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/admin/dashboard', function () {
    return redirect()->route('admin.orders');
})->middleware(['auth', 'verified'])->name('admins.dashboard');

Route::get('/user/dashboard', function () {
    return view('user.dashboard');
})->middleware(['auth', 'verified'])->name('users.dashboard');


// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController1::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController1::class, 'destroy'])->name('profile.destroy');
// });

//admin
Route::middleware('auth')->group(function () {
    Route::get('/customers', [CustomerController::class, 'index'])->name('admin.customers');

   //product routes
    Route::get('/products',[MealController::class, 'index'])->name('meals');
    Route::get('/products/listing', [MealController::class, 'listing'])->name('meals.ajax');

   
   //orders
    Route::get('/orders',[OrderController::class, 'index'])->name('admin.orders');

   //profile
    Route::POST('/admin/profile/update',[ProfileController::class, 'update'])->name('admin.profile.update');

});


require __DIR__.'/auth.php';
