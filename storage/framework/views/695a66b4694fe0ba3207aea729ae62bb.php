<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/logo website.png')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>SIGAP - <?php echo $__env->yieldContent('title', 'Sistem Informasi Gangguan dan Pelaporan'); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/sigap.css', 'resources/js/app.js']); ?>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>

<header class="header">
    <button type="button" class="mobile-menu-btn" onclick="toggleSidebar()" aria-label="Buka menu">
        <i class="fas fa-bars"></i>
    </button>
    <img src="<?php echo e(asset('images/logo website.png')); ?>" alt="Logo SIGAP" class="header-logo-img">
    <div class="header-title">
        <h1>SIGAP</h1>
        <p>Sistem Informasi Gangguan dan Pelaporan</p>
    </div>
    <img src="<?php echo e(asset('images/logo website.png')); ?>" alt="Logo SIGAP" class="header-logo-img">
    <form method="POST" action="<?php echo e(route('logout')); ?>" class="header-user">
        <?php echo csrf_field(); ?>
        <span class="header-user-name">
            <?php echo e(auth()->user()->name); ?> (<?php echo e(auth()->user()->role); ?>)
        </span>
        <button type="submit" class="btn btn-secondary header-logout">Logout</button>
    </form>
</header>

<div class="layout">
    <div id="sidebarOverlay" class="sidebar-overlay" onclick="toggleSidebar()"></div>
    <nav class="sidebar">
        <a href="<?php echo e(route('dashboard')); ?>" class="<?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
            <i class="fas fa-chart-line icon"></i> Dashboard
        </a>
        <a href="<?php echo e(route('input')); ?>" class="<?php echo e(request()->routeIs('input') ? 'active' : ''); ?>">
            <i class="fas fa-pen-to-square icon"></i> Input Laporan
        </a>
        <a href="<?php echo e(route('data-kejadian')); ?>" class="<?php echo e(request()->routeIs('data-kejadian') ? 'active' : ''); ?>">
            <i class="fas fa-database icon"></i> Data Kejadian
        </a>
        <a href="<?php echo e(route('grafik')); ?>" class="<?php echo e(request()->routeIs('grafik') ? 'active' : ''); ?>">
            <i class="fas fa-chart-bar icon"></i> Grafik
        </a>
        <a href="<?php echo e(route('laporan.index')); ?>" class="<?php echo e(request()->routeIs('laporan.*') ? 'active' : ''); ?>">
            <i class="fas fa-file-alt icon"></i> Laporan
        </a>
        <?php if(auth()->user()->isAdmin()): ?>
        <a href="<?php echo e(route('users.index')); ?>" class="<?php echo e(request()->segment(1) == 'users' ? 'active' : ''); ?>">
            <i class="fas fa-users icon"></i> Manajemen Anggota
        </a>
        <?php endif; ?>
    </nav>

    <main class="main">
        <?php echo $__env->yieldContent('content'); ?>
    </main>
</div>

<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\arjunabimantara\sigap\resources\views/layouts/sigap.blade.php ENDPATH**/ ?>