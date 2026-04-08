@extends('dashboard.layouts.app')

@section('page-title', 'Transactions')

@section('content')

    <div class="container">

        {{-- Header --}}
        <div class="header">
            <h1>Transactions</h1>
            <a href="{{ route('transactions.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Transaction
            </a>
        </div>

        {{-- Summary Cards --}}
        <div class="summary">
            <div class="summary-item income">
                <div class="summary-item-label">Total Income (This Month)</div>
                <div class="summary-item-value">
                    NPR {{ number_format($filteredIncome, 2) }}
                </div>
            </div>
            <div class="summary-item expense">
                <div class="summary-item-label">Total Expense (This Month)</div>
                <div class="summary-item-value">
                    NPR {{ number_format($filteredExpense, 2) }}
                </div>
            </div>
            <div class="summary-item balance">
                <div class="summary-item-label">Net Balance</div>
                <div class="summary-item-value">
                    NPR {{ number_format($filteredBalance, 2) }}
                </div>
            </div>
        </div>

        {{-- Transactions Table --}}
        <div class="card">

            {{-- Filters --}}
            <div class="filters">
                <form method="GET" action="{{ route('transactions.index') }}">
                    <div class="filter-group">
                        <select name="type" onchange="this.form.submit()">
                            <option value="">Type (All)</option>
                            <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>
                                Income
                            </option>
                            <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>
                                Expense
                            </option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <input type="month" name="month" value="{{ request('month', now()->format('Y-m')) }}"
                            onchange="this.form.submit()">
                    </div>
                    <div class="filter-group">
                        <input type="search" name="search" value="{{ request('search') }}" placeholder="Search by note...">
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-search"></i> Search
                    </button>
                    @if(request()->anyFilled(['type', 'month', 'search']))
                        <a href="{{ route('transactions.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    @endif
                </form>
            </div>

            {{-- Table --}}
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Category</th>
                            <th>Note</th>
                            <th>Payment</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                            <tr>

                                {{-- Date --}}
                                <td>{{ $transaction->date->format('d M Y') }}</td>

                                {{-- Category --}}
                                <td>
                                    <span class="category-badge">
                                        <span class="category-dot" style="background-color:{{ $transaction->category->color }}">
                                        </span>
                                        {{ $transaction->category->name }}
                                    </span>
                                </td>

                                {{-- Note --}}
                                <td>{{ $transaction->note ?? '—' }}</td>

                                {{-- ===== PAYMENT METHOD ===== --}}
                                {{--
                                $transaction->payment_method_label
                                Uses accessor from Transaction model
                                'esewa' → '📱 eSewa'
                                'cash' → '💵 Cash'
                                Shows emoji + label — clean and readable
                                --}}
                                <td>
                                    <span class="payment-badge payment-{{ $transaction->payment_method }}">
                                        {{ $transaction->payment_method_label }}
                                    </span>
                                </td>

                                {{-- Type --}}
                                <td>
                                    <span class="type-badge {{ $transaction->type }}">
                                        {{ ucfirst($transaction->type) }}
                                    </span>
                                </td>

                                {{-- Amount --}}
                                <td>
                                    <span class="amount {{ $transaction->type }}">
                                        {{ $transaction->type == 'income' ? '+' : '-' }}
                                        NPR {{ number_format($transaction->amount, 2) }}
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td class="actions">
                                    <a href="{{ route('transactions.edit', $transaction) }}" class="btn-icon">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('transactions.destroy', $transaction) }}" method="POST"
                                        onsubmit="return confirm('Delete this transaction?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <p>No transactions yet. Add your first transaction!</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="pagination">
                {{ $transactions->links() }}
            </div>

        </div>

    </div>

@endsection