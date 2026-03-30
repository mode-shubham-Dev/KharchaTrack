@extends('dashboard.layouts.app')

@section('page-title', 'Admin Panel')

@section('content')

    <div class="container">

        {{-- ===== HEADER ===== --}}
        <div class="header">
            <i class="fas fa-shield" style="color:#6366f1;"></i>
            <h1>Admin Panel</h1>
        </div>

        {{-- ===== STATS GRID ===== --}}
        {{-- Platform wide — no user filter --}}
        <div class="stats-grid">

            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-people-group"></i>
                </div>
                <div class="stat-content">
                    <h3>Total Users</h3>
                    <div class="number">{{ $totalUsers }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="fas fa-arrow-right-arrow-left"></i>
                </div>
                <div class="stat-content">
                    <h3>Total Transactions</h3>
                    <div class="number">{{ $totalTransactions }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-arrow-trend-up"></i>
                </div>
                <div class="stat-content">
                    <h3>Total Income</h3>
                    <div class="number">NPR {{ number_format($totalIncome, 2) }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon red">
                    <i class="fas fa-arrow-trend-down"></i>
                </div>
                <div class="stat-content">
                    <h3>Total Expense</h3>
                    <div class="number">NPR {{ number_format($totalExpense, 2) }}</div>
                </div>
            </div>

        </div>

        {{-- ===== USERS TABLE ===== --}}
        <div class="table-card">

            <div class="table-header">
                <i class="fas fa-users" style="color:#6366f1;"></i>
                <h2>All Users</h2>
            </div>

            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Transactions</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>

                                {{-- Name --}}
                                <td>
                                    <div class="user-name-cell">
                                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ $user->name }}"
                                            alt="{{ $user->name }}">
                                        <span class="name">{{ $user->name }}</span>
                                        @if($user->id === auth()->id())
                                            <span class="you-tag">You</span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Email --}}
                                <td style="color:#64748b;">
                                    {{ $user->email }}
                                </td>

                                {{-- Role --}}
                                <td>
                                    @if($user->hasRole('admin'))
                                        <span class="badge admin">
                                            <i class="fas fa-shield"></i>
                                            Admin
                                        </span>
                                    @else
                                        <span class="badge user">
                                            <i class="fas fa-user"></i>
                                            User
                                        </span>
                                    @endif
                                </td>

                                {{-- Transactions Count --}}
                                <td style="text-align:center; font-weight:600;">
                                    {{ $user->transactions_count }}
                                </td>

                                {{-- Status --}}
                                <td>
                                    @if($user->is_active)
                                        <span class="badge active">
                                            <i class="fas fa-circle" style="font-size:7px;"></i>
                                            Active
                                        </span>
                                    @else
                                        <span class="badge inactive">
                                            <i class="fas fa-circle" style="font-size:7px;"></i>
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td>
                                    @if($user->id !== auth()->id())
                                        <div class="admin-actions">

                                            {{-- Toggle Role --}}
                                            <form action="{{ route('admin.toggle-role', $user) }}" method="POST"
                                                onsubmit="return confirm('Change role for {{ $user->name }}?')">
                                                @csrf
                                                <button type="submit" class="btn-role">
                                                    <i class="fas fa-user-shield"></i>
                                                    {{ $user->hasRole('admin') ? 'Make User' : 'Make Admin' }}
                                                </button>
                                            </form>

                                            {{-- Toggle Status --}}
                                            <form action="{{ route('admin.toggle-status', $user) }}" method="POST"
                                                onsubmit="return confirm('{{ $user->is_active ? 'Deactivate' : 'Activate' }} {{ $user->name }}?')">
                                                @csrf
                                                <button type="submit" class="btn-status">
                                                    <i class="fas fa-power-off"></i>
                                                    {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>

                                        </div>
                                    @else
                                        <span style="color:#94a3b8; font-size:12px; font-style:italic;">
                                            Your account
                                        </span>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <i class="fas fa-users"></i>
                                        <p>No users found</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="pagination" style="padding:16px 24px;">
                {{ $users->links() }}
            </div>

        </div>

    </div>

@endsection