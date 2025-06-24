<?php

namespace App\Http\Requests\Address;

use Illuminate\Foundation\Http\FormRequest;

class AddressUpdateRequest extends FormRequest
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
            'phone' => 'sometimes|min:10|max:10',
            'primary_landmark' => 'sometimes|string',
            'city'=> 'sometimes|string',
            'state' =>'sometimes|string',
            'pincode' => 'sometimes|min:6'
        ];
    }
}
