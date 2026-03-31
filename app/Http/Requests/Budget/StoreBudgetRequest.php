<?php

namespace App\Http\Requests\Budget;

use Illuminate\Foundation\Http\FormRequest;

class StoreBudgetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'amount'      => 'required|numeric|min:1',
            'month'       => 'required|integer|between:1,12',
            'year'        => 'required|integer|min:2020',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Please select a category',
            'category_id.exists'   => 'Selected category does not exist',
            'amount.required'      => 'Please enter a budget amount',
            'amount.numeric'       => 'Amount must be a number',
            'amount.min'           => 'Amount must be at least NPR 1',
            'month.required'       => 'Please select a month',
            'month.between'        => 'Month must be between 1 and 12',
            'year.required'        => 'Please select a year',
            'year.min'             => 'Year must be 2020 or later',
        ];
    }
}