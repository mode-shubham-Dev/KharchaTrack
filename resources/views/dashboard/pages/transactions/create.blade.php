@extends('dashboard.layouts.app')

@section('page-title', 'Add Transaction')

@section('content')

<div class="form-container">

    {{-- Header --}}
    <div class="header">
        <a href="{{ route('transactions.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1>Add Transaction</h1>
    </div>

    {{-- Form Card --}}
    <div class="form-card">
        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf

            {{-- TYPE TOGGLE --}}
            <div class="form-group">
                <label>Type *</label>
                <div class="type-toggle">
                    <input type="radio" name="type" value="income"
                        id="typeIncome"
                        {{ old('type', 'income') == 'income' ? 'checked' : '' }}
                        style="display:none;">
                    <input type="radio" name="type" value="expense"
                        id="typeExpense"
                        {{ old('type') == 'expense' ? 'checked' : '' }}
                        style="display:none;">

                    <div class="type-btn income {{ old('type', 'income') == 'income' ? 'active' : '' }}"
                        id="incomeBtnDisplay"
                        onclick="
                            document.getElementById('typeIncome').checked = true;
                            document.getElementById('incomeBtnDisplay').classList.add('active');
                            document.getElementById('expenseBtnDisplay').classList.remove('active');
                        ">
                        <i class="fas fa-arrow-down"></i> Income
                    </div>

                    <div class="type-btn expense {{ old('type') == 'expense' ? 'active' : '' }}"
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
                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                        value="{{ old('amount') }}"
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
                    value="{{ old('date', now()->format('Y-m-d')) }}">
                @error('date')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            {{-- ===== PAYMENT METHOD ===== --}}
            {{--
                $paymentMethods comes from TransactionController
                Transaction::PAYMENT_METHODS constant
                [
                    'cash'          => '💵 Cash',
                    'esewa'         => '📱 eSewa',
                    'khalti'        => '📱 Khalti',
                    'bank_transfer' => '🏦 Bank Transfer',
                    'connectips'    => '💳 ConnectIPS',
                    'atm'           => '🏧 ATM Withdrawal',
                ]

                old('payment_method', 'cash'):
                - old() remembers value if validation fails
                - 'cash' is default — most common in Nepal
            --}}
            <div class="form-group">
                <label for="payment_method">Payment Method *</label>
                <select id="payment_method" name="payment_method">
                    @foreach($paymentMethods as $value => $label)
                        <option value="{{ $value }}"
                            {{ old('payment_method', 'cash') == $value ? 'selected' : '' }}>
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
                    placeholder="Add a note about this transaction...">{{ old('note') }}</textarea>
                @error('note')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            {{-- Buttons --}}
            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-plus"></i> Add Transaction
                </button>
                <a href="{{ route('transactions.index') }}" class="btn-cancel">
                    Cancel
                </a>
            </div>

        </form>
    </div>

</div>

@endsection