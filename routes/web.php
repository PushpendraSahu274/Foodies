<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\CartController;
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
    return redirect()->route('meals');
})->middleware(['auth', 'verified'])->name('users.dashboard');

// --------------------------------------------------------------------------------------------------------------------
// ************************************************** ADMIN ROUTES ****************************************************
// --------------------------------------------------------------------------------------------------------------------

Route::middleware(['auth'])->group(function () {

    // **************************************** CUSTOMER ****************************************
    Route::middleware('role:admin')->group(function(){
    Route::get('/customers', [CustomerController::class, 'index'])->name('admin.customers');
    Route::get('/customers/listing', [CustomerController::class, 'listing'])->name('customers.listing');
    Route::get('/customers/{id}/profile', [CustomerController::class, 'showProfile']);
    });

    // **************************************** MEAL *******************************************
    
    Route::get('/products', [MealController::class, 'index'])->name('meals');
    Route::middleware('role:admin')->group(function(){
        Route::post('/products/store', [MealController::class, 'store'])->name('meals.store');
        Route::post('/products/update', [MealController::class, 'update'])->name('meals.update');
        Route::get('/products/listing', [MealController::class, 'listing'])->name('meals.ajax');
        Route::get('/meal/delete/{id}', [MealController::class, 'destroy']);
    });
    


    // *************************************** ORDER ******************************************
    Route::middleware('role:admin')->group(function(){
        Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders');
        Route::get('/orders/listing', [OrderController::class, 'listing'])->name('orders.listing');
        Route::get('/orders/{id}', [OrderController::class, 'show']);
        Route::post('order/update/status', [OrderController::class, 'update_status']);
    });
    // ******************************************PROFILE******************************************

    Route::POST('/admin/profile/update', [ProfileController::class, 'update'])->middleware('role:admin')->name('admin.profile.update');
});

// --------------------------------------------------------------------------------------------------------------------
// ************************************************** CUSTOMER ROUTES ****************************************************
// --------------------------------------------------------------------------------------------------------------------

Route::middleware('auth')->prefix('customer')->name('customer.')->group(function(){
    Route::post('/meals/ajax',[MealController::class, 'customer_meal_ajax'])->name('meal.ajax');


    //************************************************* CART *************************************************************
    Route::get('/cart/add/{id}',[CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart/index',[CartController::class, 'showMYCart'])->name('cart.index');
    Route::post('/cart/remove',[CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/update',[CartController::class, 'updateMyCart'])->name('cart.update');


    //************************************************* ORDER *************************************************************
    Route::get('/order/index',[OrderController::class, 'index'])->name('order.index');
    Route::post('/order/store',[OrderController::class, 'store'])->name('order.store');
    
    
    //************************************************* PROFILE *************************************************************
    Route::get('/profile/show',[ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/update',[ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/destroy',[ProfileController::class, 'destroy'])->name('profile.destroy');

     //************************************************* CUSTOMER *************************************************************
    Route::get('/address/update',[AddressController::class, 'update'])->name('address.update');
});




require __DIR__ . '/auth.php';
