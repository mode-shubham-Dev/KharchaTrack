@extends('dashboard.layouts.app')

@section('page-title', 'Edit Category')

@section('content')

    <div class="form-container">

        {{-- Header --}}
        <div class="header">
            <a href="{{ route('categories.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <h1>Edit Category</h1>
        </div>

        {{-- Form Card --}}
        <div class="form-card">
            {{--
            WHY PUT/PATCH?
            HTML forms only support GET and POST
            @method('PUT') tells Laravel this is actually
            a PUT request → hits update() in controller
            --}}
            <form action="{{ route('categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Name --}}
                {{--
                old('name', $category->name)
                First checks if there's old input (validation failed)
                If not → shows current category name from database
                --}}
                <div class="form-group">
                    <label for="name">Category Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}"
                        placeholder="e.g., Groceries" autocomplete="off">
                    @error('name')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Color --}}
                {{--
                old('color', $category->color)
                Shows current category color as default
                --}}
                <div class="form-group">
                    <label for="color">Color *</label>
                    <input type="color" id="color" name="color" value="{{ old('color', $category->color) }}">
                    <div class="color-preview">
                        <div class="color-sample" id="colorSample"
                            style="background-color: {{ old('color', $category->color) }}">
                        </div>
                        <div class="color-value" id="colorValue">
                            {{ old('color', $category->color) }}
                        </div>
                    </div>
                    @error('color')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Type --}}
                {{--
                For select we check old value first
                then fall back to current category type
                Three way check:
                1. old value (if validation failed)
                2. current category type (normal edit)
                --}}
                <div class="form-group">
                    <label for="type">Category Type *</label>
                    <select id="type" name="type">
                        <option value="">Select a type</option>
                        <option value="income" {{ old('type', $category->type) == 'income' ? 'selected' : '' }}>
                            Income
                        </option>
                        <option value="expense" {{ old('type', $category->type) == 'expense' ? 'selected' : '' }}>
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
                        <i class="fas fa-check"></i> Update Category
                    </button>
                    <a href="{{ route('categories.index') }}" class="btn-cancel">
                        Cancel
                    </a>
                </div>

            </form>
        </div>

        {{--
        DANGER ZONE
        Delete form is separate from update form
        Uses DELETE method via @method('DELETE')
        Has confirmation before submitting
        --}}
        <div class="danger-zone">
            <div class="danger-zone-title">
                <i class="fas fa-exclamation-triangle"></i> Danger Zone
            </div>
            <form action="{{ route('categories.destroy', $category) }}" method="POST"
                onsubmit="return confirm('Are you sure you want to delete {{ $category->name }}? This cannot be undone.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-delete-full">
                    <i class="fas fa-trash"></i> Delete Category
                </button>
            </form>
        </div>

    </div>

@endsection