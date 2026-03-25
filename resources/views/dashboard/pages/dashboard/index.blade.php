@extends('dashboard.layouts.app')

@section('page-title', 'Dashboard')

@section('content')
    <main class="main-content">
        <!-- Summary Cards -->
        <div class="summary-cards">
            <div class="summary-card income">
                <div class="card-icon">
                    <i class="fas fa-arrow-trend-up"></i>
                </div>
                <div class="card-content">
                    <p class="card-label">Total Income</p>
                    <h3 class="card-amount">NPR 0.00</h3>
                </div>
            </div>

            <div class="summary-card expense">
                <div class="card-icon">
                    <i class="fas fa-arrow-trend-down"></i>
                </div>
                <div class="card-content">
                    <p class="card-label">Total Expense</p>
                    <h3 class="card-amount">NPR 0.00</h3>
                </div>
            </div>

            <div class="summary-card balance">
                <div class="card-icon">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="card-content">
                    <p class="card-label">Net Balance</p>
                    <h3 class="card-amount">NPR 0.00</h3>
                </div>
            </div>

            <div class="summary-card month">
                <div class="card-icon">
                    <i class="fas fa-calendar"></i>
                </div>
                <div class="card-content">
                    <p class="card-label">This Month</p>
                    <h3 class="card-amount">NPR 0.00</h3>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="charts-section">
            <div class="chart-placeholder">
                <div class="chart-placeholder-content">
                    <i class="fas fa-chart-pie"></i>
                    <p>Spending by Category</p>
                </div>
            </div>

            <div class="chart-placeholder">
                <div class="chart-placeholder-content">
                    <i class="fas fa-chart-bar"></i>
                    <p>Monthly Overview</p>
                </div>
            </div>
        </div>

        <!-- Recent Transactions Table -->
        <div class="transactions-section">
            <h2 class="section-title">Recent Transactions</h2>

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
                        <tr>
                            <td>2025-03-24</td>
                            <td><span class="category-badge">Groceries</span></td>
                            <td>Weekly shopping</td>
                            <td><span class="type-badge expense">Expense</span></td>
                            <td class="amount-cell expense-text">-NPR 2,500.00</td>
                        </tr>
                        <tr>
                            <td>2025-03-24</td>
                            <td><span class="category-badge">Salary</span></td>
                            <td>Monthly salary</td>
                            <td><span class="type-badge income">Income</span></td>
                            <td class="amount-cell income-text">+NPR 50,000.00</td>
                        </tr>
                        <tr>
                            <td>2025-03-23</td>
                            <td><span class="category-badge">Entertainment</span></td>
                            <td>Movie tickets</td>
                            <td><span class="type-badge expense">Expense</span></td>
                            <td class="amount-cell expense-text">-NPR 800.00</td>
                        </tr>
                        <tr>
                            <td>2025-03-23</td>
                            <td><span class="category-badge">Utilities</span></td>
                            <td>Electricity bill</td>
                            <td><span class="type-badge expense">Expense</span></td>
                            <td class="amount-cell expense-text">-NPR 1,200.00</td>
                        </tr>
                        <tr>
                            <td>2025-03-22</td>
                            <td><span class="category-badge">Transport</span></td>
                            <td>Taxi fare</td>
                            <td><span class="type-badge expense">Expense</span></td>
                            <td class="amount-cell expense-text">-NPR 300.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection