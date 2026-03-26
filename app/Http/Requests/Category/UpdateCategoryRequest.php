<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'  => 'required|string|max:255',
            'color' => 'required|string|max:7',
            'type'  => 'required|in:income,expense',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'  => 'Category name is required',
            'color.required' => 'Please pick a color',
            'type.required'  => 'Please select income or expense',
            'type.in'        => 'Type must be income or expense',
        ];
    }
}