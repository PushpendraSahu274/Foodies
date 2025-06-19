<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function index()
    {
        $orders = Order::get();
        $profile = User::where("role", 'admin')->first();
        return view('admin.orders.index', compact('orders', 'profile'));
    }

    public function show($id){
        $order = Order::with(['items','customer'])->findOrFail($id);
        return view('admin.orders.partials.details',compact('order'));
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

    public function update_status(Request $request){

        Order::where('id',$request->id)
                ->update(['status'=>$request->status]);
        
        return response()->json([
            'sucess' => true,
            'message' => 'Order status marked as '.$request->status,
        ]);
    }
}
