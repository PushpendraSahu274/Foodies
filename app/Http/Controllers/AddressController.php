<?php

namespace App\Http\Controllers;

use App\Http\Requests\Address\AddressStoreRequest;
use App\Http\Requests\Address\AddressUpdateRequest;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AddressController extends Controller
{
    //
    public function update(AddressUpdateRequest $request, $id)
    {

        try {
            DB::beginTransaction();
            $user = Auth::user();
            $user = User::find($user->id);
            $address = Address::where('user_id', $user->id)->where('id', $request->id)->firstOrFail();

            $address->primary_landmark = trim($request->primary_landmark) ? trim($request->primary_landmark) : $address->primary_landmark;
            $address->secondary_landmark = trim($request->secondary_landmark) ? trim($request->secondary_landmark) : $address->secondary_landmark;
            $address->city = trim($request->city) ? trim($request->city) : $address->city;
            $address->state = trim($request->state) ? trim($request->state) : $address->state;
            $address->pincode = trim($request->pincode) ? trim($request->pincode) : $address->pincode;
            $address->remark = trim($request->remark) ? trim($request->remark) : $address->remark;

            if (! $request->boolean('is_default') && !$user->default_address) {
                $address->is_default = 1; //make this one is default address;
            }

            if ($request->boolean('is_default')) {
                Address::where('user_id', $user->id)->update([
                    'is_default' => 0,
                ]);
                $address->is_default  = 1; //mark this one default
            }

            $address->save();
            DB::commit();
            return redirect()->back()->with(['message' => 'Address Updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::message('Error while updating address . ' . $e->getMessage());
            abort(500, 'Error Occured! ' . $e->getMessage());
        }
    }

    public function store(AddressStoreRequest $request)
    {
        $user_id = Auth::user()->id; //auth user fetched.

        $user = User::find($user_id);
        try {
            if (trim($request->address)) {
                $address = strtolower(trim($request->address));
            } else {
                $address = strtolower(trim($request->primary_landmark));
                if ($request->secondary_landmark) {
                    $address .= ', ' . strtolower(trim($request->secondary_landmark));
                }
                $address .= ', ' . strtolower(trim($request->city));
                $address .= ', ' . strtolower(trim($request->state));
                $address .= ' - ' . trim($request->pincode);
            }

            //make this address default if has none-defautl address
            $default = 0;
            if ($request->boolean('is_default')) {
                Address::where('user_id', $user->id)->update([
                    'is_default' => 0,
                ]);

                $default = 1;
            }

            if (!$request->boolean('is_default') && !$user->default_address) {
                $default = 1;
            }

            DB::beginTransaction();
            Address::insert([
                'user_id' => $user->id,
                'primary_landmark' => strtolower(trim($request->primary_landmark)),
                'secondary_landmark' => trim($request->secondary_address) ? strtolower(trim($request->secondary_landmark)) : null,
                'city' => strtolower(trim($request->city)),
                'state' => strtolower(trim($request->state)),
                'pincode' => trim($request->pincode),
                'phone' => trim($request->phone),
                'address' => $address,
                'remark' => trim($request->remark) ? strtolower(trim($request->remark)) : null,
                'is_default' => $default,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::commit();

            return redirect()->back()->with(['message' => 'Address stored successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::message('Error while storing address ' . $e->getMessage());
            abort(500, 'Error Occured !' . $e->getMessage());
        }
    }

    public function destroy(Request $request)
    {

        $request->validate([
            'id' => 'required|exists:addresses,id',
        ]);
        $user = Auth::user();
        try {
            DB::beginTransaction();
            $address = Address::find($request->id);
            if ($address->is_default || $user->address_count == 1) {
                return redirect()->back()->withErrors(['error' => 'Default address or only one address cannot be deleted.']);
            }

            $address->delete(); //soft delete the user address;

            DB::commit();
            return redirect()->back()->with(['message' => 'Address removed successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error occured while deleting address . ' . $e->getMessage());
            abort(500, 'Error Occured! ' . $e->getMessage());
        }
    }
}
