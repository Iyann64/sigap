

<?php $__env->startSection('title', 'Laporan'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-title">
    <span></span> Laporan Kejadian
</div>

<div class="card">
    <div class="card-title">Filter Laporan</div>

    <form method="GET" action="<?php echo e(route('laporan.index')); ?>">
        <div class="form-grid">
            <div class="form-group">
                <label>Tanggal Awal</label>
                <input type="date" name="tanggal_awal" class="form-control" value="<?php echo e(request('tanggal_awal')); ?>">
            </div>

            <div class="form-group">
                <label>Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" class="form-control" value="<?php echo e(request('tanggal_akhir')); ?>">
            </div>

           <div class="form-group">
                <label>Jenis Gangguan <span class="req">*</span></label>

                <select name="jenis_kejadian"
                        id="jenisGangguanSelect"
                        class="form-control"
                        required>

                    <option value="">-- Pilih Jenis Gangguan --</option>

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

                <div id="customJenisGangguanGroup"
                    style="display:none; margin-top:10px;">

                    <input type="text"
                        name="custom_jenis_gangguan"
                        id="customJenisGangguan"
                        class="form-control"
                        placeholder="Masukkan jenis gangguan lainnya">
                </div>

                <?php $__errorArgs = ['jenis_kejadian'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="form-hint" style="color:#e53935">
                        <?php echo e($message); ?>

                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
                <label>&nbsp;</label>
                <div class="form-actions" style="margin-top:0; justify-content:flex-start;">
                    <button type="submit" class="btn btn-primary">Filter</button>

                    <a href="<?php echo e(route('laporan.pdf', request()->query())); ?>" class="btn btn-secondary">
                        PDF
                    </a>

                    <a href="<?php echo e(route('laporan.excel', request()->query())); ?>" class="btn btn-secondary">
                        Excel
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="card">
    <div class="card-title">Riwayat Logbook Kejadian</div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kronologi</th>
                <th>Jenis Gangguan</th>
                <th>Lokasi</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $laporan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($loop->iteration); ?></td>
                    <td><?php echo e(Str::limit($item->kronologi, 50)); ?></td>
                    <td><?php echo e($item->jenis_kejadian); ?></td>
                    <td><?php echo e($item->lokasi); ?></td>
                    <td>
                        <?php echo e($item->tanggal_waktu ? \Carbon\Carbon::parse($item->tanggal_waktu)->format('d/m/Y H:i') : '-'); ?>

                    </td>
                    <td>
                        <span class="badge badge-green">Tercatat</span>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" style="text-align:center;">
                        Data laporan kosong
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectJenis = document.getElementById('jenisGangguanSelect');
    const customGroup = document.getElementById('customJenisGangguanGroup');
    const customInput = document.getElementById('customJenisGangguan');

    function cekLainLain() {
        if (selectJenis.value === 'Lain Lain') {
            customGroup.style.display = 'block';
            customInput.required = true;
            customInput.focus();
        } else {
            customGroup.style.display = 'none';
            customInput.required = false;
            customInput.value = '';
        }
    }

    cekLainLain();
    selectJenis.addEventListener('change', cekLainLain);
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.sigap', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sigap\resources\views/laporan/index.blade.php ENDPATH**/ ?>