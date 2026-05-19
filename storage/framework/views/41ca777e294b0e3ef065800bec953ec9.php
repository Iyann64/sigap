<?php $__env->startSection('title', 'Manajemen Anggota'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-title">
    <span></span> Manajemen Anggota
</div>

<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
        <div class="table-meta">
            Total Anggota: <strong><?php echo e($usersGrouped->flatten()->count()); ?></strong>
        </div>
        <a href="<?php echo e(route('users.create')); ?>" class="btn btn-primary">Tambah Anggota</a>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php $__empty_1 = true; $__currentLoopData = $usersGrouped; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $regu => $members): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="regu-section" style="margin-bottom: 30px;">
            <h3 style="margin-bottom: 12px; color: var(--blue-main); font-size: 16px; border-bottom: 2px solid var(--bg); padding-bottom: 8px;">
                <i class="fas fa-users-cog"></i> Regu: <?php echo e($regu); ?>

            </h3>
            <table>
                <thead>
                    <tr>
                        <th style="width:48px">No.</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Nama Personel</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th style="width:120px; text-align:center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($i + 1); ?>.</td>
                        <td><?php echo e($user->name); ?></td>
                        <td><?php echo e($user->email); ?></td>
                        <td><?php echo e($user->nama_personel); ?></td>
                        <td><span class="badge <?php echo e($user->role == 'admin' ? 'badge-admin' : 'badge-anggota'); ?>"><?php echo e(ucfirst($user->role)); ?></span></td>
                        <td><?php echo e($user->is_active ? 'Aktif' : 'Nonaktif'); ?></td>
                        <td style="text-align:center">
                            <a href="<?php echo e(route('users.edit', $user)); ?>" style="color:var(--orange); font-size:12px; font-weight:700; text-decoration:none; margin-right:8px;">Edit</a>
                            <form action="<?php echo e(route('users.destroy', $user)); ?>" method="POST" style="display:inline" onsubmit="return confirm('Hapus anggota ini?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" style="background:none; border:none; color:#e53935; font-size:12px; font-weight:700; cursor:pointer;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p style="text-align: center; padding: 20px; color: var(--text-light);">Belum ada data anggota.</p>
    <?php endif; ?>
</div>

<style>
.badge-admin { background: #e0f2fe; color: #0369a1; }
.badge-anggota { background: #f0fdf4; color: #166534; }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sigap', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sigap\resources\views/users/index.blade.php ENDPATH**/ ?>