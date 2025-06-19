<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Mail;


Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/admin/dashboard', function () {
    return redirect()->route('admin.orders');
})->middleware(['auth', 'verified'])->name('admins.dashboard');

Route::get('/user/dashboard', function () {
    return view('user.dashboard');
})->middleware(['auth', 'verified'])->name('users.dashboard');

//admin
Route::middleware('auth')->group(function () {
    Route::get('/customers', [CustomerController::class, 'index'])->name('admin.customers');
    Route::get('/customers/listing', [CustomerController::class, 'listing'])->name('customers.listing');
    Route::get('/customers/{id}/profile', [CustomerController::class, 'showProfile']);


    //product routes
    Route::get('/products', [MealController::class, 'index'])->name('meals');
    Route::post('/products/store', [MealController::class, 'store'])->name('meals.store');
    Route::post('/products/update', [MealController::class, 'update'])->name('meals.update');
    Route::get('/products/listing', [MealController::class, 'listing'])->name('meals.ajax');
    Route::get('/meal/delete/{id}', [MealController::class, 'destroy']);


    //orders
    Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders');
    Route::get('/orders/listing', [OrderController::class, 'listing'])->name('orders.listing');
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::post('order/update/status', [OrderController::class, 'update_status']);

    //profile
    Route::POST('/admin/profile/update', [ProfileController::class, 'update'])->name('admin.profile.update');
});


require __DIR__ . '/auth.php';
