<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function index(){
        $orders = Order::get();
        $profile = User::where("role",'admin')->first();
        return view('admin.orders.index',compact('orders','profile'));
    }
}
