<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo website.png') }}">
    <title>SIGAP - @yield('title', 'Sistem Informasi Gangguan dan Pelaporan')</title>
    @vite(['resources/css/sigap.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>

<header class="header">
    <img src="{{ asset('images/logo website.png') }}" alt="Logo SIGAP" class="header-logo-img">
    <div class="header-title">
        <h1>SIGAP</h1>
        <p>Sistem Informasi Gangguan dan Pelaporan</p>
    </div>
    <img src="{{ asset('images/logo website.png') }}" alt="Logo SIGAP" class="header-logo-img">
    <form method="POST" action="{{ route('logout') }}" style="position:absolute; right:18px; display:flex; align-items:center; gap:10px;">
        @csrf
        <span style="font-size:12px; color:rgba(255,255,255,0.85); font-weight:700;">
            {{ auth()->user()->name }} ({{ auth()->user()->role }})
        </span>
        <button type="submit" class="btn btn-secondary" style="padding:7px 12px; box-shadow:none;">Logout</button>
    </form>
</header>

<div class="layout">
    <nav class="sidebar">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <span class="icon">D</span> Dashboard
        </a>
        <a href="{{ route('input') }}" class="{{ request()->routeIs('input') ? 'active' : '' }}">
            <span class="icon">I</span> Input Laporan
        </a>
        <a href="{{ route('data-kejadian') }}" class="{{ request()->routeIs('data-kejadian') ? 'active' : '' }}">
            <span class="icon">K</span> Data Kejadian
        </a>
        <a href="{{ route('grafik') }}" class="{{ request()->routeIs('grafik') ? 'active' : '' }}">
            <span class="icon">G</span> Grafik
        </a>
    </nav>

    <main class="main">
        @yield('content')
    </main>
</div>

@stack('scripts')
</body>
</html>
