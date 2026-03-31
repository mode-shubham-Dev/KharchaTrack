<x-guest-layout>

    {{-- Heading --}}
    <h2 class="auth-heading">Create Account 🎉</h2>
    <p class="auth-subheading">Start tracking your finances today</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Name --}}
        <div class="auth-form-group">
            <label for="name">Full Name</label>
            <div class="auth-input-wrapper">
                <i class="fas fa-user auth-input-icon"></i>
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Shubham Karna"
                    autocomplete="name" autofocus>
            </div>
            @error('name')
                <div class="auth-input-error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Email --}}
        <div class="auth-form-group">
            <label for="email">Email</label>
            <div class="auth-input-wrapper">
                <i class="fas fa-envelope auth-input-icon"></i>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com"
                    autocomplete="email">
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
                <input type="password" id="password" name="password" placeholder="••••••••" autocomplete="new-password">
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

        {{-- Confirm Password --}}
        <div class="auth-form-group">
            <label for="password_confirmation">Confirm Password</label>
            <div class="auth-input-wrapper">
                <i class="fas fa-lock auth-input-icon"></i>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••"
                    autocomplete="new-password">
                <button type="button" class="auth-toggle-password">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            @error('password_confirmation')
                <div class="auth-input-error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Submit --}}
        <button type="submit" class="auth-btn">
            <i class="fas fa-user-plus"></i>
            Create Account
        </button>

        <div class="auth-footer-text">
            Already have an account?
            <a href="{{ route('login') }}">Sign in</a>
        </div>

    </form>

</x-guest-layout>