<?php $__env->startSection('title', 'Edit Anggota'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-title"><span></span> Edit Data Anggota</div>
<div class="card">
    <form action="<?php echo e(route('users.update', $user)); ?>" method="POST">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <div class="form-grid">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="name" class="form-control" value="<?php echo e(old('name', $user->name)); ?>" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo e(old('email', $user->email)); ?>" required>
            </div>
            <div class="form-group">
                <label>Password (Kosongkan jika tidak ganti)</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="form-group">
                <label>Hak Akses</label>
                <select name="role" class="form-control" required>
                    <option value="anggota" <?php echo e($user->role == 'anggota' ? 'selected' : ''); ?>>Anggota</option>
                    <option value="admin" <?php echo e($user->role == 'admin' ? 'selected' : ''); ?>>Admin</option>
                </select>
            </div>
            <div class="form-group">
                <label>Nama Lengkap Personel</label>
                <input type="text" name="nama_personel" class="form-control" value="<?php echo e(old('nama_personel', $user->nama_personel)); ?>" required>
            </div>
            <div class="form-group">
                <label>Regu</label>
                <select name="regu" class="form-control">
                    <?php $__currentLoopData = ['Alpha', 'Bravo', 'Charlie', 'Delta']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($r); ?>" <?php echo e(old('regu', $user->regu) == $r ? 'selected' : ''); ?>><?php echo e($r); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="form-group">
                <label>Shift</label>
                <select name="shift" class="form-control">
                    <?php $__currentLoopData = ['Pagi', 'Siang', 'Malam']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($s); ?>" <?php echo e(old('shift', $user->shift) == $s ? 'selected' : ''); ?>><?php echo e($s); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="form-group" style="display:flex; align-items:center; gap:10px; padding-top:25px">
                <input type="checkbox" name="is_active" value="1" <?php echo e($user->is_active ? 'checked' : ''); ?> id="is_active">
                <label for="is_active" style="margin:0">Akun Aktif</label>
            </div>
        </div>
        <div class="form-actions" style="margin-top:20px">
            <a href="<?php echo e(route('users.index')); ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Update Data</button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sigap', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sigap\resources\views/users/edit.blade.php ENDPATH**/ ?>