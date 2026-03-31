<x-guest-layout>

    {{-- Error Message --}}
    @if(session('error'))
        <div class="auth-error">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- Status Message --}}
    @if(session('status'))
        <div class="auth-error" style="background:#dcfce7; color:#166534; border-color:#bbf7d0;">
            <i class="fas fa-check-circle"></i>
            {{ session('status') }}
        </div>
    @endif

    {{-- Heading --}}
    <h2 class="auth-heading">Welcome Back 👋</h2>
    <p class="auth-subheading">Sign in to your KharchaTrack account</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div class="auth-form-group">
            <label for="email">Email</label>
            <div class="auth-input-wrapper">
                <i class="fas fa-envelope auth-input-icon"></i>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com"
                    autocomplete="email" autofocus>
            </div>
            @error('email')
                <div class="auth-input-error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Password --}}
        <div class="auth-form-group">
            <label for="password">Password</label>
            <div class="auth-input-wrapper">
                <i class="fas fa-lock auth-input-icon"></i>
                <input type="password" id="password" name="password" placeholder="••••••••"
                    autocomplete="current-password">
                <button type="button" class="auth-toggle-password">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            @error('password')
                <div class="auth-input-error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Remember Me + Forgot Password --}}
        <div class="auth-form-row">
            <div class="auth-checkbox-wrapper">
                <input type="checkbox" id="remember_me" name="remember">
                <label for="remember_me">Remember me</label>
            </div>
            @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="auth-forgot-link">
                    Forgot password?
                </a>
            @endif
        </div>

        {{-- Submit --}}
        <button type="submit" class="auth-btn">
            <i class="fas fa-sign-in-alt"></i>
            Sign In
        </button>

        <div class="auth-divider"><span>or</span></div>

        <div class="auth-footer-text">
            Don't have an account?
            <a href="{{ route('register') }}">Create one</a>
        </div>

    </form>

</x-guest-layout>