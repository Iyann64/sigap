<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo website.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>SIGAP - @yield('title', 'Sistem Informasi Gangguan dan Pelaporan')</title>
    @vite(['resources/css/sigap.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>

<header class="header">
    <button type="button" class="mobile-menu-btn" onclick="toggleSidebar()" aria-label="Buka menu">
        <i class="fas fa-bars"></i>
    </button>
    <img src="{{ asset('images/logo website.png') }}" alt="Logo SIGAP" class="header-logo-img">
    <div class="header-title">
        <h1>SIGAP</h1>
        <p>Sistem Informasi Gangguan dan Pelaporan</p>
    </div>
    <img src="{{ asset('images/logo website.png') }}" alt="Logo SIGAP" class="header-logo-img">
    <form method="POST" action="{{ route('logout') }}" class="header-user">
        @csrf
        <span class="header-user-name">
            {{ auth()->user()->name }} ({{ auth()->user()->role }})
        </span>
        <button type="submit" class="btn btn-secondary header-logout">Logout</button>
    </form>
</header>

<div class="layout">
    <div id="sidebarOverlay" class="sidebar-overlay" onclick="toggleSidebar()"></div>
    <nav class="sidebar">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-line icon"></i> Dashboard
        </a>
        <a href="{{ route('input') }}" class="{{ request()->routeIs('input') ? 'active' : '' }}">
            <i class="fas fa-pen-to-square icon"></i> Input Laporan
        </a>
        <a href="{{ route('data-kejadian') }}" class="{{ request()->routeIs('data-kejadian') ? 'active' : '' }}">
            <i class="fas fa-database icon"></i> Data Kejadian
        </a>
        <a href="{{ route('grafik') }}" class="{{ request()->routeIs('grafik') ? 'active' : '' }}">
            <i class="fas fa-chart-bar icon"></i> Grafik
        </a>
        <a href="{{ route('laporan.index') }}" class="{{ request()->routeIs('laporan.*') ? 'active' : '' }}">
            <i class="fas fa-file-alt icon"></i> Laporan
        </a>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('users.index') }}" class="{{ request()->segment(1) == 'users' ? 'active' : '' }}">
            <i class="fas fa-users icon"></i> Manajemen Anggota
        </a>
        @endif
    </nav>

    <main class="main">
        @yield('content')
    </main>
</div>

@stack('scripts')
</body>
</html>
