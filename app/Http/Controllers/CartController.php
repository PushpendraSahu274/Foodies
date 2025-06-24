<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\CartRemoveRequest;
use App\Http\Requests\Cart\CartUpdateRequest;
use App\Models\Cart;
use App\Models\Meal;
use App\Models\User;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    //
    use UploadImageTrait;
    public function addToCart($id)
    {
        try {
            DB::beginTransaction();
            $meal = Meal::findOrFail($id);
            //check stock availability
            if ($meal->quantity <= 0 || !$meal->is_available) {
                return response()->json([
                    'success' => false,
                    'message' => "Sorry, meal is out of stock currently",
                ], 400);
            }
            $user = Auth::user();

            $cart = Cart::where('user_id', $user->id)->where('meal_id', $meal->id)->first();

            //confirm only available quantity user can add in cart, not more than that.
            if ($cart && $cart->quantity >= $meal->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Can not add more than available stock!',
                ], 200);
            }


            if ($cart) {
                $cart->quantity += 1; //update the quantity;
                $cart->save();
            } else {
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
            Log::error('Error occured while adding meal to cart. ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error Occured! ' . $e->getMessage(),
            ], 500);
        }
    }

    public function showMYCart()
    {
        $user = Auth::user();
        $carts = Cart::with(['item', 'item.category'])->where('user_id', $user->id)->get();

        $carts = $carts->map(function ($cart) {
            $item = $cart->item;

            // If it's already an array (e.g., from previous transformation), cast to object
            if (is_array($item)) {
                $item = (object) $item;
            }

            return (Object)[
                'id' => $cart->id,
                'quantity' => $cart->quantity,
                'item_price' => $cart->item_price,
                
                'total_amount' => $cart->total_amount,
                'item_total_discount' => $cart->item_total_discount,
                'item' =>(Object) [
                    'id' => $cart->item->id,
                    'title' => $cart->item->title,
                    'is_available' => $cart->item->is_available,
                    'description' => $cart->item->description,
                    // 'picture_path' => $cart->item->picture_path && $this->isCloudinaryResourceExists($cart->item->picture_path)
                    //     ? $this->getCloudinaryResourceUrl($cart->item->picture_path)
                    //     : null,
                    'picture_path' => $cart->item->picture_path && $this->isImageExistsInLocal($cart->item->picture_path)
                            ? $this->getLocalImageUrl($cart->item->picture_path)
                            : null,
                    'mrp' => $cart->item->mrp,
                    'discount_percentage' => $cart->item->discount_percentage,
                    'category' => (Object) [
                        'category_name' => optional($cart->item->category)->category_name,
                    ],
                ],
            ];
        })->filter();
        return view('user.cart.my-cart', compact('carts'));
    }

    public function removeFromCart(CartRemoveRequest $request)
    {
        try {
            $cart = Cart::findOrFail($request->cart_id);
            $cart->delete();
            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart successfully!'
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error occcured', $e->getMessage());
            return response()->json([
                'success' => false,
                'Message' => 'Error occured !' . $e->getMessage(),
            ], 500);
        }
    }

    public function updateMyCart(Request $request)
    {
        try {
            DB::beginTransaction();
            $cart = Cart::with('item')->findOrFail($request->cart_id);
            $meal = $cart->item;
            $quantity = $request->quantity;
            if ($quantity > $meal->quantity) {
                //return repsnose can not add item into cart.
                return response()->json([
                    'success' => false,
                    'message' => 'Can not add item into cart',
                ], 400);
            }
            $cart->update([
                'quantity' => $quantity,
            ]);
            $cart->refresh();
            
            DB::commit();
            // return updated total_price, total_discount
            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully !',
                'cart' => [
                    'item_price' => $cart->item_price,
                    'total_amount' => $cart->total_amount,
                    'item_total_discount' => $cart->item_total_discount
                ],
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Cart Update Error.', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error Occured !' . $e->getMessage(),
            ], 500);
        }
    }
}
