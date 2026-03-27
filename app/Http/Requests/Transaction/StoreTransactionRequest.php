<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'type'        => 'required|in:income,expense',
            'amount'      => 'required|numeric|min:1',
            'note'        => 'nullable|string|max:255',
            'date'        => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Please select a category',
            'category_id.exists'   => 'Selected category does not exist',
            'type.required'        => 'Please select income or expense',
            'type.in'              => 'Type must be income or expense',
            'amount.required'      => 'Please enter an amount',
            'amount.numeric'       => 'Amount must be a number',
            'amount.min'           => 'Amount must be at least 1',
            'date.required'        => 'Please select a date',
            'date.date'            => 'Please enter a valid date',
        ];
    }
}