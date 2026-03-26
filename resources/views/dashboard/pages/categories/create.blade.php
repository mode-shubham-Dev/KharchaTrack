@extends('dashboard.layouts.app')

@section('page-title', 'Add Category')

@section('content')

    <div class="form-container">

        {{-- Header --}}
        <div class="header">
            <a href="{{ route('categories.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <h1>Add New Category</h1>
        </div>

        {{-- Form Card --}}
        <div class="form-card">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf

                {{-- Name --}}
                <div class="form-group">
                    <label for="name">Category Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="e.g., Groceries"
                        autocomplete="off">
                    @error('name')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Color --}}
                <div class="form-group">
                    <label for="color">Color *</label>
                    <input type="color" id="color" name="color" value="{{ old('color', '#6366f1') }}">
                    <div class="color-preview">
                        <div class="color-sample" id="colorSample" style="background-color: {{ old('color', '#6366f1') }}">
                        </div>
                        <div class="color-value" id="colorValue">
                            {{ old('color', '#6366f1') }}
                        </div>
                    </div>
                    @error('color')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Type --}}
                <div class="form-group">
                    <label for="type">Category Type *</label>
                    <select id="type" name="type">
                        <option value="">Select a type</option>
                        <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>
                            Income
                        </option>
                        <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>
                            Expense
                        </option>
                    </select>
                    @error('type')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Buttons --}}
                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-check"></i> Create Category
                    </button>
                    <a href="{{ route('categories.index') }}" class="btn-cancel">
                        Cancel
                    </a>
                </div>

            </form>
        </div>

    </div>

@endsection