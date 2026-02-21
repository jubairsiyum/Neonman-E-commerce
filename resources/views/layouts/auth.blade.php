<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'Login or Register - ' . config('app.name'))">

    <title>@yield('title', 'Authentication - ' . config('app.name', 'Neonman'))</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Facebook Pixel -->
    @include('components.facebook-pixel')

    @stack('styles')
    <style>
        /* Auth layout reset — no padding, no background, true full-viewport */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            background: #0f0f0f;
            overflow-x: hidden;
        }
    </style>
</head>
<body>

    <!-- Facebook Pixel noscript -->
    <noscript>
        @if(config('services.facebook.pixel_id'))
        <img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id={{ config('services.facebook.pixel_id') }}&ev=PageView&noscript=1"/>
        @endif
    </noscript>

    <!-- Header -->
    @include('components.header')

    <!-- Main Content — bare, no container, no padding -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('components.footer')

    <!-- Mobile Menu -->
    @include('components.mobile-menu')

    @stack('scripts')
</body>
</html>
