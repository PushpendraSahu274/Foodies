<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = User::where("role", 'user')->get();
        $profile = User::where('role', 'admin')->first();
        return view('admin.customers.index', compact('customers', 'profile'));
    }

    public function listing(Request $request)
    {
        $query = User::where('role', '<>', 'admin'); // all the customers.
        // Handle search input
        if ($searchValue = $request->input('search.value')) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('users.name', 'LIKE', "%$searchValue%")
                    ->orWhere('users.email', 'LIKE', "%$searchValue%")
                    ->orWhere('users.phone', 'LIKE', "%$searchValue%");
            });
        }

        $totalRecords = $query->count();

        $customers = $query->orderBy('users.id', 'desc')
            ->offset($request->input('start', 0))
            ->limit($request->input('length', 10))
            ->get();

        $data = [];
        $sno = $request->input('start', 0) + 1;

        foreach ($customers as $customer) {
            $profile_path = $customer->profile_path == null ? 'No Image' : '<img width="50" height="50" src="' . asset('storage/' . $customer->profile_path)  . '" class="card-img-top w-25 h-25 img-fluid rounded-circle mx-auto"></img>';
            $action = '<button class="btn btn-sm btn-primary view-profile-btn"
                            data-id="'.$customer->id.'"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#customerProfileOffcanvas">
                        View
                        ';

            $data[] = [
                // $sno++,
                $customer->id,
                $customer->name,
                $customer->email,
                $customer->phone,
                $customer->created_at->format('d M Y'),
                $profile_path,
                $action
            ];
        }

        return response()->json([
            'draw' => intval($request->input('draw', 1)),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data,
        ]);
    }

    public function showProfile($id)
    {
        $customer = User::findOrFail($id); // or Customer model
        return view('admin.customers.partials.details', compact('customer'));
    }
}
