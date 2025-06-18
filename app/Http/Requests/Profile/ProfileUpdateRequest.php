<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes','string'],
            'email' => [
                'sometimes',
                'email',
                Rule::unique('users','email')->ignore(Auth::user()->id),
                ],
            'phone' => [
                'sometimes',
                'min:10',
                Rule::unique('users','phone')->ignore(Auth::user()->id),    
            ],
        ];
    }
}
