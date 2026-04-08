@extends('dashboard.layouts.app')

@section('page-title', 'Edit Transaction')

@section('content')

<div class="form-container">

    {{-- Header --}}
    <div class="header">
        <a href="{{ route('transactions.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1>Edit Transaction</h1>
    </div>

    {{-- Form Card --}}
    <div class="form-card">
        <form action="{{ route('transactions.update', $transaction) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- TYPE TOGGLE --}}
            <div class="form-group">
                <label>Type *</label>
                <div class="type-toggle">
                    <input type="radio" name="type" value="income"
                        id="typeIncome"
                        {{ old('type', $transaction->type) == 'income' ? 'checked' : '' }}
                        style="display:none;">
                    <input type="radio" name="type" value="expense"
                        id="typeExpense"
                        {{ old('type', $transaction->type) == 'expense' ? 'checked' : '' }}
                        style="display:none;">

                    <div class="type-btn income {{ old('type', $transaction->type) == 'income' ? 'active' : '' }}"
                        id="incomeBtnDisplay"
                        onclick="
                            document.getElementById('typeIncome').checked = true;
                            document.getElementById('incomeBtnDisplay').classList.add('active');
                            document.getElementById('expenseBtnDisplay').classList.remove('active');
                        ">
                        <i class="fas fa-arrow-down"></i> Income
                    </div>

                    <div class="type-btn expense {{ old('type', $transaction->type) == 'expense' ? 'active' : '' }}"
                        id="expenseBtnDisplay"
                        onclick="
                            document.getElementById('typeExpense').checked = true;
                            document.getElementById('expenseBtnDisplay').classList.add('active');
                            document.getElementById('incomeBtnDisplay').classList.remove('active');
                        ">
                        <i class="fas fa-arrow-up"></i> Expense
                    </div>
                </div>
                @error('type')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            {{-- CATEGORY --}}
            <div class="form-group">
                <label for="category_id">Category *</label>
                <select id="category_id" name="category_id">
                    <option value="">Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $transaction->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }} ({{ ucfirst($category->type) }})
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            {{-- AMOUNT --}}
            <div class="form-group">
                <label for="amount">Amount *</label>
                <div class="amount-input-group">
                    <span class="amount-prefix">NPR</span>
                    <input
                        type="number"
                        id="amount"
                        name="amount"
                        value="{{ old('amount', $transaction->amount) }}"
                        placeholder="0.00"
                        step="0.01"
                        min="1">
                </div>
                @error('amount')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            {{-- DATE --}}
            <div class="form-group">
                <label for="date">Date *</label>
                <input
                    type="date"
                    id="date"
                    name="date"
                    value="{{ old('date', $transaction->date->format('Y-m-d')) }}">
                @error('date')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            {{-- ===== PAYMENT METHOD ===== --}}
            {{--
                old('payment_method', $transaction->payment_method)
                First checks if old input exists (validation fail)
                Falls back to existing transaction payment method
                So edit form always shows current value selected
            --}}
            <div class="form-group">
                <label for="payment_method">Payment Method *</label>
                <select id="payment_method" name="payment_method">
                    @foreach($paymentMethods as $value => $label)
                        <option value="{{ $value }}"
                            {{ old('payment_method', $transaction->payment_method) == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('payment_method')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            {{-- NOTE --}}
            <div class="form-group">
                <label for="note">Note (Optional)</label>
                <textarea
                    id="note"
                    name="note"
                    placeholder="Add a note about this transaction...">{{ old('note', $transaction->note) }}</textarea>
                @error('note')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            {{-- Buttons --}}
            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-check"></i> Update Transaction
                </button>
                <a href="{{ route('transactions.index') }}" class="btn-cancel">
                    Cancel
                </a>
            </div>

        </form>
    </div>

    {{-- Danger Zone --}}
    <div class="danger-zone">
        <div class="danger-zone-title">
            <i class="fas fa-exclamation-triangle"></i> Danger Zone
        </div>
        <p style="color:#7f1d1d; font-size:13px; margin-bottom:16px;">
            Once you delete this transaction there is no going back.
        </p>
        <form
            action="{{ route('transactions.destroy', $transaction) }}"
            method="POST"
            onsubmit="return confirm('Are you sure you want to delete this transaction?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-delete-full">
                <i class="fas fa-trash"></i> Delete Transaction
            </button>
        </form>
    </div>

</div>

@endsection