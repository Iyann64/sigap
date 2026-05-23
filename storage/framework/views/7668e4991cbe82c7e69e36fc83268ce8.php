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
                <label>Jenis Gangguan</label>

                <select name="jenis_kejadian"
                        id="jenisGangguanSelect"
                        class="form-control">

                    <option value="">-- Pilih Jenis Gangguan --</option>

                    <?php $__currentLoopData = $jenisKejadianOptions ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jenisKejadian): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($jenisKejadian); ?>" <?php echo e(request('jenis_kejadian') == $jenisKejadian ? 'selected' : ''); ?>>
                            <?php echo e($jenisKejadian); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

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
                <label>Lokasi</label>
                <select name="lokasi" class="form-control">
                    <option value="">-- Pilih Lokasi --</option>
                    <?php $__currentLoopData = ['Runway', 'Taxiway', 'Apron', 'Terminal']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lokasi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($lokasi); ?>" <?php echo e(request('lokasi') == $lokasi ? 'selected' : ''); ?>>
                            <?php echo e($lokasi); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
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
                    <td><?php echo e($laporan->firstItem() + $loop->index); ?></td>
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

    <div style="margin-top: 20px; display:flex; justify-content:center;">
        <?php echo e($laporan->links()); ?>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sigap', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sigap\resources\views/laporan/index.blade.php ENDPATH**/ ?>