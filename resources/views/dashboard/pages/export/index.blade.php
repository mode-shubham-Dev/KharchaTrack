@extends('dashboard.layouts.app')

@section('page-title', 'Export Transactions')

@section('content')

    <div class="export-container">

        {{-- Header --}}
        <div class="header">
            <a href="{{ route('dashboard') }}" class="btn-back">
                <i class="fas fa-chevron-left"></i>
            </a>
            <h1>Export Transactions</h1>
        </div>

        {{-- Export Form Card --}}
        <div class="form-card">

            {{--
            METHOD POST — downloads file
            action → export.download route
            @csrf → security token required
            --}}
            <form action="{{ route('export.download') }}" method="POST">
                @csrf

                {{-- DATE RANGE SECTION --}}
                {{--
                Two date pickers — from and to
                Quick select buttons set dates via JS
                after_or_equal validation in controller
                --}}
                <div class="form-section">
                    <div class="section-label">Date Range</div>

                    <div class="date-range">
                        <div class="export-form-group">
                            <label for="date_from">From</label>
                            <input type="date" id="date_from" name="date_from"
                                value="{{ old('date_from', now()->startOfMonth()->format('Y-m-d')) }}">
                            @error('date_from')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="export-form-group">
                            <label for="date_to">To</label>
                            <input type="date" id="date_to" name="date_to"
                                value="{{ old('date_to', now()->format('Y-m-d')) }}">
                            @error('date_to')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{--
                    Quick select buttons
                    onclick calls setDateRange() from script.js
                    type="button" prevents form submission
                    --}}
                    <div class="quick-select">
                        <button type="button" class="quick-select-btn" onclick="setDateRange('this_month')">
                            This Month
                        </button>
                        <button type="button" class="quick-select-btn" onclick="setDateRange('last_month')">
                            Last Month
                        </button>
                        <button type="button" class="quick-select-btn" onclick="setDateRange('last_3_months')">
                            Last 3 Months
                        </button>
                        <button type="button" class="quick-select-btn" onclick="setDateRange('this_year')">
                            This Year
                        </button>
                    </div>
                </div>

                {{-- FILTERS SECTION --}}
                <div class="form-section">
                    <div class="section-label">Filters (Optional)</div>

                    <div class="export-filters">

                        {{-- Type Filter --}}
                        <div class="export-form-group">
                            <label for="type">Type</label>
                            <select id="type" name="type">
                                <option value="">All</option>
                                <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>
                                    Income
                                </option>
                                <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>
                                    Expense
                                </option>
                            </select>
                        </div>

                        {{-- Category Filter --}}
                        {{--
                        $categories passed from ExportController
                        Real user categories from database
                        --}}
                        <div class="export-form-group">
                            <label for="category_id">Category</label>
                            <select id="category_id" name="category_id">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>

                {{-- DOWNLOAD BUTTON --}}
                <button type="submit" class="export-button">
                    <i class="fas fa-download"></i>
                    Download CSV
                </button>

            </form>
        </div>

        {{-- INFO CARD --}}
        {{--
        Shows user what the CSV will contain
        Dynamic filename preview based on dates
        --}}
        <div class="info-card">
            <div class="info-title">
                <i class="fas fa-info-circle"></i>
                Export Details
            </div>
            <div class="info-content">
                <p>
                    <strong>Your CSV will include:</strong>
                    Date, Category, Type, Amount, Note
                </p>
                <p><strong>File will be named:</strong></p>
                <div class="file-name">
                    transactions-[from-date]-to-[to-date].csv
                </div>
            </div>
        </div>

    </div>

@endsection