<?php $__env->startSection('title', 'Input Laporan'); ?>

<?php $__env->startSection('content'); ?>

<div class="page-title">
    <span></span> Input Laporan Kejadian
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
<?php endif; ?>
<?php if($errors->any()): ?>
    <div class="alert alert-error">Terdapat kesalahan pada form. Silakan periksa kembali.</div>
<?php endif; ?>

<div class="card">
    <form action="<?php echo e(route('input.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="form-grid">
            <div class="form-group">
                <label>Jenis Kejadian <span class="req">*</span></label>
                <select name="jenis_kejadian" id="jenisGangguanSelect" class="form-control" required>
                    <option value="">-- Pilih Jenis Kejadian --</option>
                    <option value="Kebakaran" <?php echo e(old('jenis_kejadian') == 'Kebakaran' ? 'selected' : ''); ?>>Kebakaran</option>
                    <option value="Kebakaran Hutan" <?php echo e(old('jenis_kejadian') == 'Kebakaran Hutan' ? 'selected' : ''); ?>>Kebakaran Hutan</option>
                    <option value="Hujan Deras" <?php echo e(old('jenis_kejadian') == 'Hujan Deras' ? 'selected' : ''); ?>>Hujan Deras</option>
                    <option value="Hujan Lebat" <?php echo e(old('jenis_kejadian') == 'Hujan Lebat' ? 'selected' : ''); ?>>Hujan Lebat</option>
                    <option value="Kabut Tebal" <?php echo e(old('jenis_kejadian') == 'Kabut Tebal' ? 'selected' : ''); ?>>Kabut Tebal</option>
                    <option value="Animal Hazard" <?php echo e(old('jenis_kejadian') == 'Animal Hazard' ? 'selected' : ''); ?>>Animal Hazard</option>
                    <option value="Wildlife Hazard" <?php echo e(old('jenis_kejadian') == 'Wildlife Hazard' ? 'selected' : ''); ?>>Wildlife Hazard</option>
                    <option value="Bird Strike" <?php echo e(old('jenis_kejadian') == 'Bird Strike' ? 'selected' : ''); ?>>Bird Strike</option>
                    <option value="Medis Gawat Darurat" <?php echo e(old('jenis_kejadian') == 'Medis Gawat Darurat' ? 'selected' : ''); ?>>Medis Gawat Darurat</option>
                    
                    <option value="FOD" <?php echo e(old('jenis_kejadian') == 'FOD' ? 'selected' : ''); ?>>FOD</option>
                    <option value="Runway Incursion" <?php echo e(old('jenis_kejadian') == 'Runway Incursion' ? 'selected' : ''); ?>>Runway Incursion</option>
                    <option value="Runway Excursion" <?php echo e(old('jenis_kejadian') == 'Runway Excursion' ? 'selected' : ''); ?>>Runway Excursion</option>
                    <option value="Ground Collision" <?php echo e(old('jenis_kejadian') == 'Ground Collision' ? 'selected' : ''); ?>>Ground Collision</option>
                    <option value="Lain Lain" <?php echo e(old('jenis_kejadian') == 'Lain Lain' ? 'selected' : ''); ?>>Lain Lain</option>
                </select>
                <div id="customJenisGangguanGroup" style="display:none; margin-top:10px;">
                    <input type="text"
                        name="custom_jenis_gangguan"
                        id="customJenisGangguan"
                        class="form-control"
                        placeholder="Masukkan jenis kejadian lainnya">
                </div>
                <?php $__errorArgs = ['jenis_kejadian'];
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
                <textarea name="kronologi" class="form-control" style="min-height:130px"
                    placeholder="Masukan uraian singkat tentang kronologi kejadian, penyebab, dan tindakan yang dilakukan"
                    required><?php echo e(old('kronologi')); ?></textarea>
                <?php $__errorArgs = ['kronologi'];
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
                <label>Lokasi Kejadian <span class="req">*</span></label>
                <select name="lokasi" class="form-control" required>
                    <option value="">-- Pilih Lokasi --</option>
                    <option value="Runway" <?php echo e(old('lokasi') == 'Runway' ? 'selected' : ''); ?>>Runway</option>
                    <option value="Taxiway" <?php echo e(old('lokasi') == 'Taxiway' ? 'selected' : ''); ?>>Taxiway</option>
                    <option value="Apron" <?php echo e(old('lokasi') == 'Apron' ? 'selected' : ''); ?>>Apron</option>
                    <option value="Luar Bandara" <?php echo e(old('lokasi') == 'Luar Bandara' ? 'selected' : ''); ?>>Luar Bandara</option>
                    <option value="Terminal" <?php echo e(old('lokasi') == 'Terminal' ? 'selected' : ''); ?>>Terminal</option>
                    <option value="Hanggar" <?php echo e(old('lokasi') == 'Hanggar' ? 'selected' : ''); ?>>Hanggar</option>
                </select>
                <?php $__errorArgs = ['lokasi'];
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
                <label>Tanggal & Waktu Kejadian <span class="req">*</span></label>
                <input type="datetime-local" name="tanggal_waktu" class="form-control"
                    value="<?php echo e(old('tanggal_waktu', now()->format('Y-m-d\TH:i'))); ?>" required>
                <?php $__errorArgs = ['tanggal_waktu'];
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
                <label>Foto Dokumentasi</label>
                <div class="file-input-wrapper">
                    <input type="file" name="foto" accept=".jpg,.jpeg,.png" id="fotoInput">
                    <div class="file-input-display" id="fotoDisplay">
                        <span class="file-btn">Pilih File</span>
                        <span id="fotoName">Tidak ada yang dipilih</span>
                    </div>
                </div>
                <span class="form-hint">Unggah foto dokumentasi kejadian (maks 5MB, format: JPG, PNG)</span>
                <?php $__errorArgs = ['foto'];
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
                <label>Nama Personel <span class="req">*</span></label>
                <input type="text" name="nama_personel" class="form-control"
                    placeholder="Masukan nama lengkap"
                    value="<?php echo e(old('nama_personel')); ?>" required>
                <?php $__errorArgs = ['nama_personel'];
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
                <label>Regu <span class="req">*</span></label>
                <select name="regu" class="form-control" required>
                    <option value="">-- Pilih Regu --</option>
                    <option value="Alpha" <?php echo e(old('regu') == 'Alpha' ? 'selected' : ''); ?>>Alpha</option>
                    <option value="Bravo" <?php echo e(old('regu') == 'Bravo' ? 'selected' : ''); ?>>Bravo</option>
                    <option value="Charlie" <?php echo e(old('regu') == 'Charlie' ? 'selected' : ''); ?>>Charlie</option>
                </select>
                <?php $__errorArgs = ['regu'];
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
                <label>Shift <span class="req">*</span></label>
                <select name="shift" class="form-control" required>
                    <option value="">-- Pilih Shift --</option>
                    <option value="Pagi" <?php echo e(old('shift') == 'Pagi' ? 'selected' : ''); ?>>Pagi</option>
                    <option value="Siang" <?php echo e(old('shift') == 'Siang' ? 'selected' : ''); ?>>Siang</option>
                    <option value="Malam" <?php echo e(old('shift') == 'Malam' ? 'selected' : ''); ?>>Malam</option>
                </select>
                <?php $__errorArgs = ['shift'];
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
        </div>

        <div class="form-actions">
            <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Laporan</button>
        </div>
    </form>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // FOTO INPUT
    const fotoInput = document.getElementById('fotoInput');
    const fotoName = document.getElementById('fotoName');

    if (fotoInput && fotoName) {
        fotoInput.addEventListener('change', function () {
            fotoName.textContent = this.files.length > 0
                ? this.files[0].name
                : 'Tidak ada yang dipilih';
        });
    }

   // JENIS KEJADIAN LAIN-LAIN
const jenisGangguanSelect = document.getElementById('jenisGangguanSelect');
const customJenisGangguanGroup = document.getElementById('customJenisGangguanGroup');
const customJenisGangguan = document.getElementById('customJenisGangguan');

if (jenisGangguanSelect && customJenisGangguanGroup && customJenisGangguan) {
    function toggleCustomJenisKejadian() {
        if (jenisGangguanSelect.value === 'Lain Lain') {
            customJenisGangguanGroup.style.display = 'block';
            customJenisGangguan.setAttribute('required', 'required');
        } else {
            customJenisGangguanGroup.style.display = 'none';
            customJenisGangguan.removeAttribute('required');
            customJenisGangguan.value = '';
        }
    }

    toggleCustomJenisKejadian();
    jenisGangguanSelect.addEventListener('change', toggleCustomJenisKejadian);
}

});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.sigap', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sigap\resources\views/input.blade.php ENDPATH**/ ?>