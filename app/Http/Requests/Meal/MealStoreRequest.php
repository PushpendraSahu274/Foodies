<?php

namespace App\Http\Requests\Meal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MealStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->role =='admin'; //admin access
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                function($attribute,$value,$fail){
                    if(trim($value) === ''){
                        $fail('The'.str_replace('_',' ',$attribute). ' Can not be empty or just space');
                    }
                },
                Rule::unique('meals','title'),
            ],
            'description' => [
                'required',
                function($attribute, $value, $fail){
                    if(trim($value) === ''){
                        $fail('The' .str_replace('_', ' ', $attribute) . ' Can not be emty or just space');
                    }
                }
            ],
            'price' => 'required',
            'discount' => 'required',
            'quantity' => 'required',
            'meal_category_id' => 'required|exists:meal_categories,id',
        ];
    }
}
