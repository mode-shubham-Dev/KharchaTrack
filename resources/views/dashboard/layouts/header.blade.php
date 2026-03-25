<nav class="navbar">

    {{-- Left Side - Hamburger + Page Title --}}
    <div class="navbar-left">
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <h1 class="page-title">
            @yield('page-title', 'Dashboard')
        </h1>
    </div>

    {{-- Right Side - Bell + User Dropdown --}}
    <div class="navbar-right">

        {{-- Notification Bell --}}
        <button class="notification-btn">
            <i class="fas fa-bell"></i>
            <span class="notification-badge">0</span>
        </button>

        {{-- User Dropdown --}}
        <div class="user-dropdown-container">
            <button class="user-dropdown-btn" id="userDropdownBtn">
                <img src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ auth()->user()->name }}" alt="Avatar"
                    class="user-avatar">
                <span class="user-dropdown-name">{{ auth()->user()->name }}</span>
                <i class="fas fa-chevron-down"></i>
            </button>

            {{-- Dropdown Menu --}}
            <div class="dropdown-menu" id="userDropdownMenu">

                <a href="#" class="dropdown-item">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>

                <a href="#" class="dropdown-item">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>

                <div class="dropdown-divider"></div>

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item logout-item w-full text-left">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>

            </div>
        </div>

    </div>

</nav>