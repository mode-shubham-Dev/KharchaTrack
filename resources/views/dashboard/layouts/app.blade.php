<!DOCTYPE html>
<html lang="en">

<head>
    @include('dashboard.layouts.head')
</head>

<body>

    {{-- Sidebar --}}
    @include('dashboard.layouts.sidebar')

    {{-- Header/Navbar --}}
    @include('dashboard.layouts.header')

    {{-- Main Content --}}
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

        {{-- Page Content --}}
        @yield('content')

    </main>

    {{-- Footer --}}
    @include('dashboard.layouts.footer')

    <!-- Main JS -->
    <script src="{{ asset('assets/js/script.js') }}"></script>

    <!-- Chart.js CDN — loaded on every page, lightweight -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Your custom chart code -->
    <script src="{{ asset('assets/js/charts.js') }}"></script>

    @stack('scripts')

</body>

</html>