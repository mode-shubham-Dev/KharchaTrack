@extends('dashboard.layouts.app')

@section('page-title', 'Budgets')

@section('content')

<div class="container">

    {{-- ===== HEADER ===== --}}
    <div class="header">
        <h1>
            <i class="fas fa-piggy-bank" style="color:#6366f1;"></i>
            Budgets
        </h1>
        {{-- Month/Year filter — GET form, auto submits on change --}}
        <form method="GET" action="{{ route('budgets.index') }}" class="budget-filter">
            <select name="month" onchange="this.form.submit()">
                @foreach(range(1, 12) as $m)
                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                    </option>
                @endforeach
            </select>
            <select name="year" onchange="this.form.submit()">
                @foreach(range(2020, now()->year + 1) as $y)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    {{-- ===== SUMMARY CARDS ===== --}}
    <div class="budget-summary-grid">

        <div class="budget-stat-card indigo">
            <div class="budget-stat-label">
                <i class="fas fa-wallet"></i> Total Budget
            </div>
            <div class="budget-stat-amount">
                NPR {{ number_format($totalBudget, 2) }}
            </div>
            <div class="budget-stat-sub">
                {{ DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}
            </div>
        </div>

        <div class="budget-stat-card light">
            <div class="budget-stat-label">
                <i class="fas fa-money-bill-wave"></i> Total Spent
            </div>
            <div class="budget-stat-amount">
                NPR {{ number_format($totalSpent, 2) }}
            </div>
            <div class="budget-stat-sub">
                @if($totalBudget > 0)
                    {{ round(($totalSpent / $totalBudget) * 100) }}% of budget used
                @else
                    No budget set yet
                @endif
            </div>
        </div>

    </div>

    {{-- ===== BUDGET LIST ===== --}}
    <h2 class="budget-section-title">Your Budgets</h2>

    <div class="budget-list">
        @forelse($budgets as $budget)
            <div class="budget-item">

                {{-- Top row: name + amount + delete --}}
                <div class="budget-item-header">
                    <div class="budget-name">
                        <span class="budget-color-dot"
                            style="background-color:{{ $budget->category->color }}">
                        </span>
                        {{ $budget->category->name }}
                    </div>
                    <div class="budget-amount-right">
                        <span class="budget-limit">
                            NPR {{ number_format($budget->amount, 2) }}
                        </span>
                        <form
                            action="{{ route('budgets.destroy', $budget) }}"
                            method="POST"
                            onsubmit="return confirm('Remove budget for {{ $budget->category->name }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="budget-delete-btn">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Progress bar --}}
                <div class="progress-container">
                    <div class="progress-top">
                        <span class="progress-pct">{{ $budget->percentage }}%</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill {{ $budget->status }}"
                            style="width:{{ min($budget->percentage, 100) }}%">
                        </div>
                    </div>
                </div>

                {{-- Bottom row: spent text + status badge --}}
                <div class="budget-item-footer">
                    <span class="budget-spent-text">
                        NPR {{ number_format($budget->spent, 2) }} spent
                        of NPR {{ number_format($budget->amount, 2) }}
                        @if($budget->remaining > 0)
                            &nbsp;·&nbsp;
                            <span style="color:#22c55e; font-weight:600;">
                                NPR {{ number_format($budget->remaining, 2) }} left
                            </span>
                        @else
                            &nbsp;·&nbsp;
                            <span style="color:#ef4444; font-weight:600;">
                                NPR {{ number_format(abs($budget->remaining), 2) }} over!
                            </span>
                        @endif
                    </span>

                    <span class="budget-status-badge budget-status-{{ $budget->status }}">
                        @if($budget->status == 'safe')
                            <i class="fas fa-check-circle"></i> Safe
                        @elseif($budget->status == 'moderate')
                            <i class="fas fa-circle-info"></i> Moderate
                        @elseif($budget->status == 'warning')
                            <i class="fas fa-circle-exclamation"></i> Warning
                        @else
                            <i class="fas fa-triangle-exclamation"></i> Over Budget!
                        @endif
                    </span>
                </div>

            </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-piggy-bank"></i>
                <p>No budgets set for
                    {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                    {{ $year }}
                </p>
                <p style="font-size:13px; margin-top:8px; color:#94a3b8;">
                    Use the form below to set your first budget
                </p>
            </div>
        @endforelse
    </div>

    {{-- Categories without budget warning --}}
    @if($categoriesWithoutBudget->count() > 0)
        <div class="budget-warning-box">
            <p class="budget-warning-title">
                <i class="fas fa-lightbulb"></i>
                {{ $categoriesWithoutBudget->count() }} categories have no budget set:
            </p>
            <div class="budget-warning-tags">
                @foreach($categoriesWithoutBudget as $cat)
                    <span class="budget-warning-tag">
                        <span class="budget-warning-tag-dot"
                            style="background:{{ $cat->color }}">
                        </span>
                        {{ $cat->name }}
                    </span>
                @endforeach
            </div>
        </div>
    @endif

    {{-- ===== SET BUDGET FORM ===== --}}
    <div class="budget-form-card">
        <div class="budget-form-title">
            <i class="fas fa-plus"></i>
            Set New Budget
        </div>

        <form action="{{ route('budgets.store') }}" method="POST">
            @csrf

            {{-- Category --}}
            <div class="budget-form-group">
                <label class="budget-form-label">
                    Category <span class="required">*</span>
                </label>
                <select name="category_id" class="budget-form-select">
                    <option value="">Select expense category</option>
                    @foreach($categoriesWithoutBudget as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                    @if($budgets->count() > 0)
                        <optgroup label="── Update existing budget ──">
                            @foreach($budgets as $b)
                                <option value="{{ $b->category_id }}"
                                    {{ old('category_id') == $b->category_id ? 'selected' : '' }}>
                                    {{ $b->category->name }} (NPR {{ number_format($b->amount, 0) }}) ✓
                                </option>
                            @endforeach
                        </optgroup>
                    @endif
                </select>
                @error('category_id')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            {{-- Amount --}}
            <div class="budget-form-group">
                <label class="budget-form-label">
                    Budget Amount <span class="required">*</span>
                </label>
                <div class="budget-input-group">
                    <span class="budget-input-prefix">NPR</span>
                    <input
                        type="number"
                        name="amount"
                        class="budget-form-input"
                        placeholder="Enter budget limit"
                        value="{{ old('amount') }}"
                        min="1"
                        step="0.01">
                </div>
                @error('amount')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            {{-- Period --}}
            <div class="budget-form-group">
                <label class="budget-form-label">
                    Period <span class="required">*</span>
                </label>
                <div class="budget-form-row">
                    <div>
                        <select name="month" class="budget-form-select">
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}"
                                    {{ old('month', $month) == $m ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                                </option>
                            @endforeach
                        </select>
                        @error('month')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <select name="year" class="budget-form-select">
                            @foreach(range(2020, now()->year + 1) as $y)
                                <option value="{{ $y }}"
                                    {{ old('year', $year) == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endforeach
                        </select>
                        @error('year')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <button type="submit" class="budget-submit-btn">
                <i class="fas fa-floppy-disk"></i>
                Save Budget
            </button>

        </form>
    </div>

</div>

@endsection