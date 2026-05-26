<?php $__env->startSection('title', 'Edit Laporan'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-title"><span></span> Edit Laporan Kejadian</div>
<div class="card">
    <form action="<?php echo e(route('data-kejadian.update', $kejadian)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <div class="form-grid">
            <div class="form-group">
                <label>Jenis Kejadian <span class="req">*</span></label>
                <?php
                    $options = [
                        'Kebakaran',
                        'Kebakaran Hutan',
                        'Hujan Deras',
                        'Hujan Lebat',
                        'Kabut Tebal',
                        'Animal Hazard',
                        'Wildlife Hazard',
                        'Bird Strike',
                        'Medis Gawat Darurat',
                        'FOD',
                        'Runway Incursion',
                        'Runway Excursion',
                        'Ground Collision',
                    ];
                    $selectedJenis = old('jenis_kejadian', in_array($kejadian->jenis_kejadian, $options, true) ? $kejadian->jenis_kejadian : 'Lain Lain');
                    $customJenis = old('custom_jenis_kejadian', in_array($kejadian->jenis_kejadian, $options, true) ? '' : $kejadian->jenis_kejadian);
                ?>
                <select name="jenis_kejadian" id="jenisKejadianSelect" class="form-control" required>
                    <option value="">-- Pilih Jenis Kejadian --</option>
                    <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($opt); ?>" <?php echo e($selectedJenis == $opt ? 'selected' : ''); ?>><?php echo e($opt); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <option value="Lain Lain" <?php echo e($selectedJenis == 'Lain Lain' ? 'selected' : ''); ?>>Lain Lain</option>
                </select>
            </div>
            
            <div id="customJenisKejadianGroup" class="form-group" style="display:none;">
                <label>Sebutkan Jenis Kejadian <span class="req">*</span></label>
                <input type="text" name="custom_jenis_kejadian" id="customJenisKejadian" class="form-control" value="<?php echo e($customJenis); ?>">
                <?php $__errorArgs = ['custom_jenis_kejadian'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="form-hint" style="color:#e53935"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group" style="grid-row: span 2;">
                <label>Kronologi Kejadian <span class="req">*</span></label>
                <textarea name="kronologi" class="form-control" style="min-height:130px" required><?php echo e(old('kronologi', $kejadian->kronologi)); ?></textarea>
            </div>

            <div class="form-group">
                <label>Lokasi Kejadian <span class="req">*</span></label>
                <?php
                    $lokasiOptions = ['Runway', 'Taxiway', 'Apron', 'Luar Bandara', 'Terminal', 'Hanggar'];
                    $selectedLokasi = old('lokasi', in_array($kejadian->lokasi, $lokasiOptions, true) ? $kejadian->lokasi : 'Lain Lain');
                    $customLokasi = old('custom_lokasi', in_array($kejadian->lokasi, $lokasiOptions, true) ? '' : $kejadian->lokasi);
                ?>
                <select name="lokasi" id="lokasiSelect" class="form-control" required>
                    <?php $__currentLoopData = $lokasiOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($loc); ?>" <?php echo e($selectedLokasi == $loc ? 'selected' : ''); ?>><?php echo e($loc); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <option value="Lain Lain" <?php echo e($selectedLokasi == 'Lain Lain' ? 'selected' : ''); ?>>Lain Lain</option>
                </select>
                <div id="customLokasiGroup" style="display:none; margin-top:10px;">
                    <input type="text" name="custom_lokasi" id="customLokasi" class="form-control" value="<?php echo e($customLokasi); ?>" placeholder="Masukkan lokasi lainnya">
                </div>
                <?php $__errorArgs = ['custom_lokasi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="form-hint" style="color:#e53935"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                    <?php $__currentLoopData = ['Pagi','Malam']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
    const select = document.getElementById('jenisKejadianSelect');
    const customGroup = document.getElementById('customJenisKejadianGroup');
    const customInput = document.getElementById('customJenisKejadian');
    function checkCustom() {
        const isCustom = select.value === 'Lain Lain';
        customGroup.style.display = isCustom ? 'block' : 'none';
        if (isCustom) {
            customInput.setAttribute('required', 'required');
        } else {
            customInput.removeAttribute('required');
            customInput.value = '';
        }
    }
    select.addEventListener('change', checkCustom);
    window.onload = checkCustom;

    const lokasiSelect = document.getElementById('lokasiSelect');
    const customLokasiGroup = document.getElementById('customLokasiGroup');
    const customLokasi = document.getElementById('customLokasi');
    function checkCustomLokasi() {
        const isCustom = lokasiSelect.value === 'Lain Lain';
        customLokasiGroup.style.display = isCustom ? 'block' : 'none';
        if (isCustom) {
            customLokasi.setAttribute('required', 'required');
        } else {
            customLokasi.removeAttribute('required');
            customLokasi.value = '';
        }
    }
    lokasiSelect.addEventListener('change', checkCustomLokasi);
    checkCustomLokasi();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.sigap', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sigap\resources\views/data-kejadian-edit.blade.php ENDPATH**/ ?>