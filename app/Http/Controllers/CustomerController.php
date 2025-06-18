<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request){
        $customers = User::where("role",'user')->get();
        $profile = User::where('role','admin')->first();
        return view('admin.customers.index',compact('customers','profile'));
    }
}
