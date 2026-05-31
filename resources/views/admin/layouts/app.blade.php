<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Админ-панель')</title>
    <link href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('/css/admin.css')) }}" rel="stylesheet"/>
    @stack('styles')
</head>
<body class="bg-gray-100 min-h-screen">
    @auth
        @include('admin.partials.nav')
        <div class="@yield('container-class', 'max-w-6xl') mx-auto px-4 py-6">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @yield('content')
        </div>
    @else
        <div class="min-h-screen flex items-center justify-center px-4">
            @yield('login')
        </div>
    @endauth
    @stack('scripts')
</body>
</html>
