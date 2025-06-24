<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    use UploadImageTrait;
    public function index(Request $request)
    {
        $customers = User::where("role", 'user')->get();
        $profile = User::where('role', 'admin')->first();

        $customers->map(function($customer){
            if($customer->avatar){
                $customer->profile_path = $customer->avatar;
            }
            elseif($customer->profile_path){
                $customer->profile_path = $this->getLocalImageUrl($customer->profile_path);
            }
            return $customer;
        });
        
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

            // if ($customer->avatar) {
            //     $profile_path = $customer->avatar; //signup with google
            // } elseif ($customer->profile_path && $this->isCloudinaryResourceExists($customer->profile_path)) {
            //     $profile_path = $this->getCloudinaryResourceUrl($customer->profile_path);
            // } else {
            //     // return the url for default image
            //     $profile_path = asset('images\costomers\default_avatar.png');
            // }

            if ($customer->avatar) {
                $profile_path = $customer->avatar; //signup with google
            } elseif ($customer->profile_path && $this->isImageExistsInLocal($customer->profile_path)) {
                $profile_path = $this->getLocalImageUrl($customer->profile_path);
            } else {
                // return the url for default image
                $profile_path = asset('images\costomers\default_avatar.png');
            }

            $profile = '<img src="'.$profile_path.'" alt="customer image" height="70px" width="70px" style="border-radius: 50%; object-fit: cover;">';

            $action = '<button class="btn btn-sm btn-primary view-profile-btn"
                            data-id="' . $customer->id . '"
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
                $profile,
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

        // if ($customer->avatar) {
        //     $customer->profile_path = $customer->avatar; //signup with google avatar
        // } elseif ($customer->profile_path && $this->isCloudinaryResourceExists($customer->profile_path)) {
        //     $customer->profile_path = $this->getCloudinaryResourceUrl($customer->profile_path);
        // } else {
        //     // return the url for default image
        //     $customer->profile_path = asset('images\costomers\default_avatar.png');
        // }
        if ($customer->avatar) {
            $customer->profile_path = $customer->avatar; //signup with google avatar
        } elseif ($customer->profile_path && $this->isImageExistsInLocal($customer->profile_path)) {
            $customer->profile_path = $this->getLocalImageUrl($customer->profile_path);
        } else {
            // return the url for default image
            $customer->profile_path = asset('images\costomers\default_avatar.png');
        }
        // dd($customer->profile_path);
        return view('admin.customers.partials.details', compact('customer'));
    }

}
