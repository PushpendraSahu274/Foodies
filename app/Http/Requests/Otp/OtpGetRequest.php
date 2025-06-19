<?php

namespace App\Http\Requests\Otp;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class OtpGetRequest extends FormRequest
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
            'email' => ['required'],
            function($attribute, $value, $fail){
                if(! User::where('email',$value)->exists()){
                    $fail('Email does not exists in our records, proceed to register!');
                }
            }
        ];
    }
}
