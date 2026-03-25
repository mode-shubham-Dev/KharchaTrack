<!DOCTYPE html>
<html lang="en">

<head>
    {{-- Pulls in head.blade.php --}}
    @include('dashboard.layouts.head')
</head>

<body>

    {{-- Pulls in sidebar.blade.php --}}
    @include('dashboard.layouts.sidebar')

    {{-- Pulls in header.blade.php --}}
    @include('dashboard.layouts.header')

    {{-- Main Content Area --}}
    <main class="main-content">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- Every page dumps its content here --}}
        @yield('content')

    </main>

    {{-- Pulls in footer.blade.php --}}
    @include('dashboard.layouts.footer')

    {{-- Custom JS --}}
    <script src="{{ asset('assets/js/script.js') }}"></script>

    {{-- Extra scripts for specific pages like charts --}}
    @stack('scripts')

</body>
</html>