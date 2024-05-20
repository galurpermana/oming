<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFoodRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'picture' => 'required|image',
            'ingredients' => 'required|array',
            'ingredients.*.type' => 'required|exists:ingredients,id', // assuming you have an ingredients table
            'ingredients.*.quantity' => 'required|numeric',
            'ingredients.*.unit' => 'required|in:Gram,Kilogram,Liter',
        ];
    }
}
