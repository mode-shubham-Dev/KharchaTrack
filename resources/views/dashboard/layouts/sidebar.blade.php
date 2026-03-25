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

        <a href="#" class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
            <i class="fas fa-arrow-right-arrow-left nav-icon"></i>
            <span class="nav-text">Transactions</span>
        </a>

        <a href="#" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
            <i class="fas fa-tag nav-icon"></i>
            <span class="nav-text">Categories</span>
        </a>

        <a href="#" class="nav-link {{ request()->routeIs('history.*') ? 'active' : '' }}">
            <i class="fas fa-clock nav-icon"></i>
            <span class="nav-text">History</span>
        </a>

        <a href="#" class="nav-link {{ request()->routeIs('export.*') ? 'active' : '' }}">
            <i class="fas fa-download nav-icon"></i>
            <span class="nav-text">Export</span>
        </a>
        
        {{-- Admin Panel link will be enabled in Module 8 after Spatie setup --}}
        {{-- <a href="#" class="nav-link">
            <i class="fas fa-shield nav-icon"></i>
            <span class="nav-text">Admin Panel</span>
        </a> --}}

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