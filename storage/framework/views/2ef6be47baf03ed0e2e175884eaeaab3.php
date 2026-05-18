<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIGAP</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/sigap.css', 'resources/js/app.js']); ?>
    <style>
        body {
            display: grid;
            place-items: center;
            padding: 24px;
        }

        .login-card {
            width: min(420px, 100%);
            background: #fff;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 28px;
        }

        .login-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 28px;
            font-weight: 800;
            color: var(--blue-dark);
            text-align: center;
            letter-spacing: 2px;
            margin-bottom: 4px;
        }

        .login-subtitle {
            text-align: center;
            color: var(--text-mid);
            font-size: 13px;
            margin-bottom: 24px;
        }

        .login-actions {
            margin-top: 20px;
        }

        .login-actions .btn {
            width: 100%;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="<?php echo e(asset('images/logo website.png')); ?>" alt="Logo SIGAP" style="max-width: 150px; height: auto;">
        </div>
        <div class="login-title">SIGAP</div>
        <div class="login-subtitle">Sistem Informasi Gangguan dan Pelaporan</div>

        <?php if($errors->any()): ?>
            <div class="alert alert-error">Email atau password tidak sesuai.</div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('login.store')); ?>">
            <?php echo csrf_field(); ?>
            <div class="form-grid full">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo e(old('email')); ?>" class="form-control" required autofocus>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <label style="display:flex; align-items:center; gap:8px; font-size:13px; color:var(--text-mid);">
                    <input type="checkbox" name="remember" value="1">
                    Ingat saya
                </label>
            </div>

            <div class="login-actions">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\sigap\resources\views/auth/login.blade.php ENDPATH**/ ?>