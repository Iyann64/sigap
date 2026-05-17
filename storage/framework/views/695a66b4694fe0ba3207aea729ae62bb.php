<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/logo website.png')); ?>">
    <title>SIGAP - <?php echo $__env->yieldContent('title', 'Sistem Informasi Gangguan dan Pelaporan'); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/sigap.css', 'resources/js/app.js']); ?>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>

<header class="header">
    <img src="<?php echo e(asset('images/logo website.png')); ?>" alt="Logo SIGAP" class="header-logo-img">
    <div class="header-title">
        <h1>SIGAP</h1>
        <p>Sistem Informasi Gangguan dan Pelaporan</p>
    </div>
    <img src="<?php echo e(asset('images/logo website.png')); ?>" alt="Logo SIGAP" class="header-logo-img">
    <form method="POST" action="<?php echo e(route('logout')); ?>" style="position:absolute; right:18px; display:flex; align-items:center; gap:10px;">
        <?php echo csrf_field(); ?>
        <span style="font-size:12px; color:rgba(255,255,255,0.85); font-weight:700;">
            <?php echo e(auth()->user()->name); ?> (<?php echo e(auth()->user()->role); ?>)
        </span>
        <button type="submit" class="btn btn-secondary" style="padding:7px 12px; box-shadow:none;">Logout</button>
    </form>
</header>

<div class="layout">
    <nav class="sidebar">
        <a href="<?php echo e(route('dashboard')); ?>" class="<?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
            <span class="icon">D</span> Dashboard
        </a>
        <a href="<?php echo e(route('input')); ?>" class="<?php echo e(request()->routeIs('input') ? 'active' : ''); ?>">
            <span class="icon">I</span> Input Laporan
        </a>
        <a href="<?php echo e(route('data-kejadian')); ?>" class="<?php echo e(request()->routeIs('data-kejadian') ? 'active' : ''); ?>">
            <span class="icon">K</span> Data Kejadian
        </a>
        <a href="<?php echo e(route('grafik')); ?>" class="<?php echo e(request()->routeIs('grafik') ? 'active' : ''); ?>">
            <span class="icon">G</span> Grafik
        </a>
    </nav>

    <main class="main">
        <?php echo $__env->yieldContent('content'); ?>
    </main>
</div>

<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\arjunabimantara\sigap\resources\views/layouts/sigap.blade.php ENDPATH**/ ?>