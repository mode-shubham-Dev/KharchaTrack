@extends('dashboard.layouts.app')

@section('page-title', 'Dashboard')

@section('content')

    {{-- ===== SUMMARY CARDS ===== --}}
    <div class="summary-cards">

        <div class="summary-card income">
            <div class="card-icon">
                <i class="fas fa-arrow-trend-up"></i>
            </div>
            <div class="card-content">
                <p class="card-label">Total Income</p>
                <h3 class="card-amount">
                    NPR {{ number_format($totalIncome, 2) }}
                </h3>
            </div>
        </div>

        <div class="summary-card expense">
            <div class="card-icon">
                <i class="fas fa-arrow-trend-down"></i>
            </div>
            <div class="card-content">
                <p class="card-label">Total Expense</p>
                <h3 class="card-amount">
                    NPR {{ number_format($totalExpense, 2) }}
                </h3>
            </div>
        </div>

        <div class="summary-card balance">
            <div class="card-icon">
                <i class="fas fa-wallet"></i>
            </div>
            <div class="card-content">
                <p class="card-label">Net Balance</p>
                <h3 class="card-amount">
                    NPR {{ number_format($netBalance, 2) }}
                </h3>
            </div>
        </div>

        <div class="summary-card month">
            <div class="card-icon">
                <i class="fas fa-calendar"></i>
            </div>
            <div class="card-content">
                <p class="card-label">Transactions</p>
                <h3 class="card-amount">
                    {{ $totalTransactions }}
                </h3>
            </div>
        </div>

    </div>

    {{-- ===== CHARTS SECTION ===== --}}
    <div class="charts-section">

        {{-- Pie Chart --}}
        <div class="chart-placeholder">
            <h3 class="chart-title">
                <i class="fas fa-chart-pie"></i>
                Spending by Category
            </h3>
            <canvas id="pieChart"></canvas>
        </div>

        {{-- Bar Chart --}}
        <div class="chart-placeholder">
            <h3 class="chart-title">
                <i class="fas fa-chart-bar"></i>
                Monthly Overview
            </h3>
            <canvas id="barChart"></canvas>
        </div>

    </div>

    {{-- ===== RECENT TRANSACTIONS ===== --}}
    <div class="transactions-section">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h2 class="section-title" style="margin:0;">Recent Transactions</h2>
            <a href="{{ route('transactions.index') }}" style="color:#6366f1; font-size:13px; font-weight:600;">
                View All →
            </a>
        </div>

        <div class="table-container">
            <table class="transactions-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Category</th>
                        <th>Note</th>
                        <th>Type</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentTransactions as $transaction)
                        <tr>
                            <td>{{ $transaction->date->format('d M Y') }}</td>
                            <td>
                                <span class="category-badge">
                                    <span class="category-dot" style="background-color: {{ $transaction->category->color }}">
                                    </span>
                                    {{ $transaction->category->name }}
                                </span>
                            </td>
                            <td>{{ $transaction->note ?? '—' }}</td>
                            <td>
                                <span class="type-badge {{ $transaction->type }}">
                                    {{ ucfirst($transaction->type) }}
                                </span>
                            </td>
                            <td>
                                <span class="amount {{ $transaction->type }}">
                                    {{ $transaction->type == 'income' ? '+' : '-' }}
                                    NPR {{ number_format($transaction->amount, 2) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="fas fa-inbox"></i>
                                    <p>No transactions yet</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
        {{--
        WHY window.spendingData and window.monthlyData?

        charts.js is an external file — it cannot directly
        access PHP variables. So we inject PHP data into
        global window object here in Blade.

        Then charts.js reads from window object.

        This is the standard pattern for passing
        PHP data to external JS files.
        --}}
        <script>
            window.spendingData = @json($spendingByCategory);
            window.monthlyData = @json($last6Months);
        </script>
    @endpush

@endsection