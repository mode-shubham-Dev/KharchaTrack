@extends('dashboard.layouts.app')

@section('page-title', 'Categories')

@section('content')

    <div class="container">

        {{-- Header --}}
        <div class="header">
            <h1>Categories</h1>
            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Category
            </a>
        </div>

        <div class="categories-grid">

            {{-- Income Categories --}}
            <div class="category-section">
                <h2 class="section-title">
                    <i class="fas fa-arrow-trend-up"></i> Income Categories
                </h2>
                <table>
                    <thead>
                        <tr>
                            <th>Color</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($incomeCategories as $category)
                            <tr>
                                <td>
                                    <span class="color-dot" style="background-color: {{ $category->color }}">
                                    </span>
                                </td>
                                <td class="category-name">
                                    {{ $category->name }}
                                </td>
                                <td>
                                    <span class="category-type type-income">
                                        Income
                                    </span>
                                </td>
                                <td class="actions">
                                    <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete {{ $category->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-delete">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <p>No income categories yet</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Expense Categories --}}
            <div class="category-section">
                <h2 class="section-title">
                    <i class="fas fa-arrow-trend-down"></i> Expense Categories
                </h2>
                <table>
                    <thead>
                        <tr>
                            <th>Color</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expenseCategories as $category)
                            <tr>
                                <td>
                                    <span class="color-dot" style="background-color: {{ $category->color }}">
                                    </span>
                                </td>
                                <td class="category-name">
                                    {{ $category->name }}
                                </td>
                                <td>
                                    <span class="category-type type-expense">
                                        Expense
                                    </span>
                                </td>
                                <td class="actions">
                                    <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete {{ $category->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-delete">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <p>No expense categories yet</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection