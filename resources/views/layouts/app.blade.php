<!DOCTYPE html>
<html>
<head>
    <title>Kafe Online</title>

    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    <style>
        html, body {
            margin: 0;
            padding: 0;
            background: #111;
            font-family: 'Poppins', sans-serif;
        }

        /* WRAPPER */
        .main-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* CONTENT */
        .content {
            flex: 1;
            padding: 25px;
            background: #18181b;
            color: #fff;
        }
    </style>

    @yield('styles')
</head>

<body>

    {{-- TOP NAVBAR --}}
    @include('components.navbar')

    {{-- MAIN WRAPPER --}}
    <div class="main-wrapper">

        {{-- ROLE-BASED SIDEBAR --}}
        @auth
            @if(auth()->user()->role === 'barista')
                @include('components.sidebar-barista')
            @elseif(auth()->user()->role === 'waiter')
                @include('components.sidebar-waiter')
            @elseif(auth()->user()->role === 'kasir')
                @include('components.sidebar-kasir')
            @endif
        @endauth

        {{-- PAGE CONTENT --}}
        <div class="content">
            @yield('content')
        </div>
    </div>

    @yield('scripts')
</body>
</html>
