<aside class="sidebar">

    {{-- Logo --}}
    <div class="sidebar-header">
        <div class="logo-container">
            <i class="fas fa-wallet logo-icon"></i>
            <span class="logo-text">KharchaTrack</span>
        </div>
    </div>

    {{-- Navigation Links --}}
    <nav class="sidebar-nav">

        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-home nav-icon"></i>
            <span class="nav-text">Dashboard</span>
        </a>

        <a href="{{ route('transactions.index') }}"
            class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
            <i class="fas fa-arrow-right-arrow-left nav-icon"></i>
            <span class="nav-text">Transactions</span>
        </a>

        <a href="{{ route('categories.index') }}"
            class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
            <i class="fas fa-tag nav-icon"></i>
            <span class="nav-text">Categories</span>
        </a>

        <a href="{{ route('transactions.index') }}"
            class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
            <i class="fas fa-clock nav-icon"></i>
            <span class="nav-text">History</span>
        </a>

        <a href="{{ route('export.index') }}" class="nav-link {{ request()->routeIs('export.*') ? 'active' : '' }}">
            <i class="fas fa-download nav-icon"></i>
            <span class="nav-text">Export</span>
        </a>

        @if (auth()->check() && auth()->user()->hasAnyRole('admin'))
            <a href="{{ route('admin.index') }}" class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                <i class="fas fa-shield nav-icon"></i>
                <span class="nav-text">Admin Panel</span>
            </a>

        @endif

    </nav>

    {{-- User Info + Logout at bottom --}}
    <div class="sidebar-footer">
        <div class="user-profile">
            <img src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ auth()->user()->name }}" alt="Avatar"
                class="user-avatar-small">
            <div class="user-info">
                <p class="user-name">{{ auth()->user()->name }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>

</aside>