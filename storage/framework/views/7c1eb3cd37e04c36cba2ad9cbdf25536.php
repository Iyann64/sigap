<?php $__env->startSection('title', 'Edit Laporan'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-title"><span></span> Edit Laporan Kejadian</div>
<div class="card">
    <form action="<?php echo e(route('data-kejadian.update', $kejadian)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <div class="form-grid">
            <div class="form-group">
                <label>Jenis Kejadian <span class="req">*</span></label>
                <select name="jenis_kejadian" class="form-control" required>
                    <?php $options = ['Kebakaran', 'Kebakaran Hutan', 'Hujan Deras', 'FOD', 'Runway Incursion', 'Runway Excursion', 'Ground Collision', 'Lain Lain']; ?>
                    <option value="">-- Pilih Jenis Kejadian --</option>
                    <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($opt); ?>" <?php echo e(old('jenis_kejadian', $kejadian->jenis_kejadian) == $opt ? 'selected' : ''); ?>><?php echo e($opt); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            
            <div id="customJenisKejadianGroup" class="form-group" style="display:none;">
                <label>Sebutkan Jenis Kejadian <span class="req">*</span></label>
                <input type="text" name="custom_jenis_kejadian" class="form-control" value="<?php echo e(old('custom_jenis_kejadian')); ?>">
            </div>

            <div class="form-group" style="grid-row: span 2;">
                <label>Kronologi Kejadian <span class="req">*</span></label>
                <textarea name="kronologi" class="form-control" style="min-height:130px" required><?php echo e(old('kronologi', $kejadian->kronologi)); ?></textarea>
            </div>

            <div class="form-group">
                <label>Lokasi Kejadian <span class="req">*</span></label>
                <select name="lokasi" class="form-control" required>
                    <?php $__currentLoopData = ['Runway', 'Taxiway', 'Apron', 'Terminal']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($loc); ?>" <?php echo e(old('lokasi', $kejadian->lokasi) == $loc ? 'selected' : ''); ?>><?php echo e($loc); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="form-group">
                <label>Tanggal & Waktu <span class="req">*</span></label>
                <input type="datetime-local" name="tanggal_waktu" class="form-control" value="<?php echo e(old('tanggal_waktu', $kejadian->tanggal_waktu->format('Y-m-d\TH:i'))); ?>" required>
            </div>

            <div class="form-group">
                <label>Foto Baru (Biarkan kosong jika tidak diubah)</label>
                <input type="file" name="foto" class="form-control" accept="image/*">
            </div>

            <div class="form-group">
                <label>Nama Personel <span class="req">*</span></label>
                <input type="text" name="nama_personel" class="form-control" value="<?php echo e(old('nama_personel', $kejadian->nama_personel)); ?>" required>
            </div>

            <div class="form-group">
                <label>Regu <span class="req">*</span></label>
                <select name="regu" class="form-control" required>
                    <?php $__currentLoopData = ['Alpha', 'Bravo', 'Charlie', 'Delta']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($r); ?>" <?php echo e(old('regu', $kejadian->regu) == $r ? 'selected' : ''); ?>><?php echo e($r); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="form-group">
                <label>Shift <span class="req">*</span></label>
                <select name="shift" class="form-control" required>
                    <?php $__currentLoopData = ['Pagi', 'Siang', 'Malam']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($s); ?>" <?php echo e(old('shift', $kejadian->shift) == $s ? 'selected' : ''); ?>><?php echo e($s); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
        <div class="form-actions">
            <a href="<?php echo e(route('data-kejadian')); ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Update Laporan</button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    const select = document.querySelector('select[name="jenis_kejadian"]');
    const customGroup = document.getElementById('customJenisKejadianGroup');
    function checkCustom() {
        customGroup.style.display = select.value === 'Lain Lain' ? 'block' : 'none';
    }
    select.addEventListener('change', checkCustom);
    window.onload = checkCustom;
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.sigap', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\arjunabimantara\sigap\resources\views/data-kejadian-edit.blade.php ENDPATH**/ ?>