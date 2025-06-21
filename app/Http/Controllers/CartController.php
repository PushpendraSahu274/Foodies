<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    //
    public function addToCart($id)
    {
        try {
            DB::beginTransaction();
            $meal = Meal::findOrFail($id);
            //check stock availability
            if($meal->quantity <= 0 || !$meal->is_available){
                return response()->json([
                    'success' => false,
                    'message' => "Sorry, meal is out of stock currently",
                ],400);
            }
            $user = Auth::user();

            $cart = Cart::where('user_id',$user->id)->where('meal_id',$meal->id)->first();

            //confirm only available quantity user can add in cart, not more than that.
            if($cart && $cart->quantity >= $meal->quantity){
                return response()->json([
                    'success' => false,
                    'message' => 'Can not add more than available stock!',
                ], 200);
            }


            if($cart){
                $cart->quantity += 1; //update the quantity;
                $cart->save();
            }
             else {
                Cart::Create([
                    'user_id' => $user->id,
                    'meal_id' => $meal->id,
                    'quantity' =>  1
                ]);
            }
            
            DB::commit();
            return response()->json([
                'sucess' => true,
                'message' => 'Meal added to cart',
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error occured while adding meal to cart. '.$e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error Occured! '.$e->getMessage(),
            ],500);
        }
    }
}
