<?php

namespace App\Http\Requests\Meal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MealUpdateRequest extends FormRequest
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
            'id' => ['required'],
            'title' => [
                'nullable',
                'sometimes',
                Rule::unique('meals', 'title')->ignore($this->id), //    
            ],
            'description' => [
                'nullable',
                'sometimes',
                function ($attribute, $value, $fail) {
                    if (trim($value) === '') {
                        $fail('The' . substr_replace('_', ' ', $attribute) . ' Can not be empty');
                    }
                },
            ],
            'price' => ['sometimes'],
            'quantity' => ['sometimes'],
            'is_available' => ['sometimes'],
            'discount' => ['sometimes']
        ];
    }
}
