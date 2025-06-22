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
            return view('admin.orders.index', compact('orders', 'profile'));
        } else {
            $user = Auth::user();
            $orders = Order::with(['items', 'items.meal', 'items.meal.category', 'address'])->where('user_id', $user->id)->get();
            $orders = $orders->map(function ($order) {
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
                            'picture_path' => $item->picture_path && $this->isCloudinaryResourceExists($item->picture_path)
                                ? $this->getCloudinaryResourceUrl($item->picture_path)
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
        $order = Order::with(['items', 'customer'])->findOrFail($id);
        return view('admin.orders.partials.details', compact('order'));
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
            $profile_path = $order->profile_path == null ? 'No Image' : '<img width="50" height="50" src="' . env("APP_URL") . $order->picture_path . '" class="card-img-top w-25 h-25 img-fluid rounded-circle mx-auto"></img>';
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

        Order::where('id', $request->id)
            ->update(['status' => $request->status]);

        return response()->json([
            'sucess' => true,
            'message' => 'Order status marked as ' . $request->status,
        ]);
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
