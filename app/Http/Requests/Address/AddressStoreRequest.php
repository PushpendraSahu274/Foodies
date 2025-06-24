<?php

namespace App\Http\Requests\Address;

use Illuminate\Foundation\Http\FormRequest;

class AddressStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
           'phone' => 'required|min:10|max:10',
           'primary_landmark' => 'required|string',
           'city'=> 'required|string',
           'state' =>'required|string',
           'pincode' => 'required|min:6'
        ];
    }
}
