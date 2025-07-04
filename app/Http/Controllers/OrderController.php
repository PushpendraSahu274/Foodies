<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\OrderPlaceRequest;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Meal;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Traits\UploadImageTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    use UploadImageTrait;
    //
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $orders = Order::get();
            $profile = User::where("role", 'admin')->first();
            if ($profile->avatar) {
                $profile->profile_path = $profile->avatar;
            } else {
                $profile->profile_path = $this->getLocalImageUrl($profile->profile_path);
            }
            return view('admin.orders.index', compact('orders', 'profile'));
        } else {
            $user = Auth::user();
            $orders = Order::with(['items', 'items.meal', 'items.meal.category', 'address'])->where('user_id', $user->id)->get();

            $orders = $orders->map(function ($order) {
                // dd($order->items->first()->picture_path);
                return [
                    'order_id' => $order->id,
                    'total_amount' => $order->total_amount,
                    'quantity' => $order->quantity,
                    'status' => $order->status,
                    'placed_at' => $order->created_at ? Carbon::parse($order->created_at)->format('d M Y H:i A') : null,
                    'delivered_at' => $order->delivered_at ? Carbon::parse($order->delivered_at)->format('d M Y H:i A') : null,
                    'confirmed_at' => $order->confirmed_at ? Carbon::parse($order->confirmed_at)->format('d M Y H:i A') : null,
                    'cancelled_at' => $order->cancelled_at ? Carbon::parse($order->cancelled_at)->format('d M Y H:i A') : null,
                    'address' => [
                        'id' => optional($order->address)->id,
                        'primary_landmark' => optional($order->address)->primary_landmark,
                        'secondary_landmark' => optional($order->address)->secondary_landmark,
                        'city' => optional($order->address)->city,
                        'state' => optional($order->address)->state,
                        'pincode' => optional($order->address)->pincode,
                        'remark' => optional($order->address)->remark,
                        'address' => optional($order->address)->address, //one line address,
                    ],
                    'order_items' => $order->items->map(function ($item) {
                        return [
                            'id' => $item->id, //returning the order_item id
                            'meal_name' => $item->meal_name,
                            // 'picture_path' => $item->picture_path && $this->isCloudinaryResourceExists($item->picture_path)
                            //     ? $this->getCloudinaryResourceUrl($item->picture_path)
                            //     : null,
                            'picture_path' => $item->picture_path && $this->isImageExistsInLocal($item->picture_path)
                                ? $this->getLocalImageUrl($item->picture_path)
                                : null,
                            'quantity' => $item->quantity,
                            'price' => $item->price,
                            'meal_id' => $item->meal_id, //meal_id infos. 
                        ];
                    }),
                ];
            });
            return view('user.order.index', compact('orders'));
        }
    }

    public function show($id)
    {
        if (Auth::check() && strtolower(Auth::user()->role) === 'admin') {
            $order = Order::with(['items', 'customer', 'address'])->findOrFail($id);
            $order->items->map(function ($item) {

                // if($item->picture_path && $this->isCloudinaryResourceExists($item->picture_path)){
                //     $item->picture_path = $this->getCloudinaryResourceUrl($item->picture_path);
                // }
                // else{
                //     $item->picute_path = '<img class="thumb" alt="no-image" />';
                // }

                if ($item->picture_path && $this->isImageExistsInLocal($item->picture_path)) {
                    $item->picture_path = $this->getLocalImageUrl($item->picture_path);
                } else {
                    $item->picute_path = '<img class="thumb" alt="no-image" />';
                }
                return $item;
            });

            if ($order->customer->avatar) {
                $order->customer->profile_path = $order->customer->avatar;
            }
            // elseif($order->customer->profile_path && $this->isCloudinaryResourceExists($order->customer->profile_path)){
            //     $order->customer->profile_path = $this->getCloudinaryResourceUrl($order->customer->profile_path);
            // }
            elseif ($order->customer->profile_path && $this->isImageExistsInLocal($order->customer->profile_path)) {
                $order->customer->profile_path = $this->getLocalImageUrl($order->customer->profile_path);
            } else {
                $order->customer->profile_path = `<img src="{{ asset('images\costomers\default_avatar.png')" alt="user-profile"  />`;
            }

            return view('admin.orders.partials.details', compact('order'));
        } else {
            $order_id = $id;
            $user = Auth::user();
            $user = User::find($user->id);
            $order = $user->orders()->with(['items','address'])->where('id',$order_id)->firstOrFail();

            $formattedOrder =  (object)[
                    'id' => $order->id,
                    'items_count' => $order->items?->count(),
                    'total_amount' => $order->total_amount,
                    'status' => $order->status,
                    'placed_at' => $order->order_place_at,
                    'confirmed_at' => $order->order_confirmed_at,
                    'delivered_at' => $order->order_delivered_at,
                    'cancelled_at' => $order->order_cancelled_at,
                    'note' => $order->note,
                    'address' => (Object)[
                        'id' => $order?->address?->id,
                        'primary_landmark' => $order?->address?->primary_landmark,
                        'secondry_landmark' => $order?->address?->secondary_landmark,
                        'city' => $order?->address?->city,
                        'state' => $order?->address?->state,
                        'pincode' => $order?->address?->pincode,
                        'phone' => $order?->address?->phone,
                        'address' => $order?->address?->address,
                        'remark' => $order?->address?->remark,
                    ],
                    'items' => $order->items?->map(function($item){
                        return (Object)[
                            'id' => $item->id,
                            'meal_name' => $item->meal_name,
                            'picture_path' => $item->picture_path && $this->isImageExistsInLocal($item->picture_path)
                                ? $this->getLocalImageUrl($item->picture_path)
                                : null,
                            'quantity' => $item->quantity,
                            'price' => $item->price
                        ];
                    }),
                    'receiver_details' => [
                        'name' => $user->name,
                        'email' => $user->email,
                    ],
                ];
            
            $order = $formattedOrder;
            return view('user.order.details',compact('order'));
           
        }
    }

    public function listing(Request $request)
    {
        $query = Order::select(
            'orders.id',
            'order_items.meal_name',
            'order_items.quantity',
            'orders.total_amount',
            'order_items.picture_path',
            'orders.user_id as customer_id',
            'users.name as customer_name',
            'orders.status'
        )
            ->Join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->Join('meals', 'meals.id', '=', 'order_items.meal_id')
            ->Join('users', 'users.id', '=', 'orders.user_id');

        if ($searchable = $request->input('search.value'))
            $query = $query->where(function ($q) use ($searchable) {
                $q->where('orders.id', 'LIKE', "%$searchable%")
                    ->orWhere('order_items.meal_name', 'LIKE', "%$searchable%")
                    ->orWhere('users.id', 'LIKE', "%$searchable%")
                    ->orWhere('users.name', 'LIKE', "%$searchable%")
                    ->orWhere('orders.status', 'LIKE', "%$searchable%");
            });

        $totalRecords = $query->count();

        $orders = $query->orderBy('orders.id', 'desc')
            ->offset($request->input('start', 0))
            ->limit($request->input('length', 10))
            ->get();

        $data = [];
        $sno = $request->input('start', 0) + 1;

        foreach ($orders as $order) {
            if ($order->picture_path && $this->isImageExistsInLocal($order->picture_path)) {
                $profile_path = '<img src="' . asset($this->getLocalImageUrl($order->picture_path)) . '" height="70px" width="70px[" alt="image" />';
            }

            $action =
                '<button class="btn btn-sm btn-danger"
                data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasWithBackdrop"
                data-order-id="' . $order->id . '">view</button>';


            $data[] = [
                $sno++,
                $order->id,
                $order->meal_name,
                $order->quantity,
                $order->total_amount,
                $profile_path,
                $order->customer_id,
                $order->customer_name,
                $order->status,
                $action
            ];
        }

        return response()->json([
            'draw' => intval($request->input('draw', 1)),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data,
        ]);

        return $orders->get();
    }

    public function update_status(Request $request)
    {
        $request->validate([
            'status' => 'required|in:confirmed,delivered,cancelled',
            'id' => 'required',
        ]);
        try {
            DB::beginTransaction();
            $order = Order::findOrFail($request->id);
            $order->status = $request->status;
            //update the time stamp
            switch ($request->status) {
                case 'confirmed':
                    $order->confirmed_at = now();
                    break;
                case 'delivered':
                    $order->delivered_at = now();
                    break;
                case 'cancelled':
                    $order->cancelled_at = now();
                    break;
            }
            $order->save();
            DB::commit();
            return response()->json([
                'sucess' => true,
                'message' => 'Order status marked as ' . $request->status,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('order status update -' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error Occured !' . $e->getMessage(),
            ], 500);
        }
    }

    public function store(OrderPlaceRequest $request)
    {
        try {
            $user = Auth::user();
            $cart = Cart::findOrFail($request->cart_id);

            if ($cart->user_id != $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                ], 403);
            }

            // Assume cart has one meal
            $meal = Meal::findOrFail($cart->meal_id);
            $address = Address::where('user_id', $user->id)->where('is_default', 1)->first();

            if (!$address) {
                return response()->json([
                    'success' => false,
                    'message' => 'Address not found!',
                ], 404);
            }

            if ($cart->quantity > $meal->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Selected quantity in cart is more than available!',
                ], 400);
            }

            DB::beginTransaction();

            // Calculate final price after discount
            $discountedPrice = $meal->mrp - (($meal->mrp * $meal->discount_percentage) / 100);
            $totalPrice = $cart->quantity * $discountedPrice;

            // Save Order
            $order = new Order();
            $order->user_id = $user->id;
            $order->quantity = $cart->quantity;
            $order->total_amount = $totalPrice;
            $order->address_id = $address->id;
            $order->status = 'pending';
            $order->save();

            //save orderItem
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->meal_name = $meal->title;
            $orderItem->picture_path = $meal->picture_path;
            $orderItem->quantity = $cart->quantity;
            $orderItem->price = $discountedPrice;
            $orderItem->meal_id = $meal->id;
            $orderItem->save();


            // decrease the meal quantity;
            $meal->quantity -= $cart->quantity;

            // Remove Cart
            $cart->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'redirect' => route('customer.order.index'),
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order placement error: ' . $e->getMessage(), ['exception' => $e]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
}
