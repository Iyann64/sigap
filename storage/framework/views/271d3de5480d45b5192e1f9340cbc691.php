

<?php $__env->startSection('title', 'Data Kejadian'); ?>

<?php $__env->startSection('content'); ?>

<div class="page-title">
    <span></span> Data Kejadian
</div>

<div class="card">

    
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; gap:12px; flex-wrap:wrap;">
        <div class="table-meta">
            Menampilkan
            <strong><?php echo e($kejadian->firstItem() ?? 1); ?></strong>
            sampai
            <strong><?php echo e($kejadian->lastItem() ?? 6); ?></strong>
            dari
            <strong><?php echo e($kejadian->total() ?? 50); ?></strong>
            data
        </div>
        <div style="display:flex; gap:10px; align-items:center;">
            <form method="GET" action="<?php echo e(route('data-kejadian')); ?>" style="display:flex; gap:8px;">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                    class="form-control" style="width:200px"
                    placeholder="🔍 Cari kejadian...">
                <button type="submit" class="btn btn-primary" style="padding:8px 16px;">Cari</button>
            </form>
            <a href="<?php echo e(route('input')); ?>" class="btn btn-primary" style="padding:8px 16px; white-space:nowrap;">
                ＋ Tambah
            </a>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:48px">No.</th>
                <th>Tanggal</th>
                <th>Jenis Kejadian</th>
                <th>Lokasi</th>
                <th>Shift Jaga</th>
                <th style="width:100px; text-align:center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $kejadian ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e(($kejadian->currentPage() - 1) * $kejadian->perPage() + $i + 1); ?>.</td>
                <td><?php echo e(\Carbon\Carbon::parse($item->tanggal_waktu)->format('d/m/Y')); ?></td>
                <td><?php echo e($item->jenis_kejadian); ?></td>
                <td><?php echo e($item->lokasi); ?></td>
                <td>
                    <span class="badge <?php echo e($item->badge_class); ?>">
                        <?php echo e($item->regu); ?>

                    </span>
                </td>
                <td style="text-align:center">
                    <a href="<?php echo e(route('data-kejadian.show', $item->id)); ?>"
                       style="color:var(--blue-main); font-size:12px; font-weight:700; text-decoration:none; margin-right:8px;">Detail</a>
                    <form action="<?php echo e(route('data-kejadian.destroy', $item->id)); ?>" method="POST"
                          style="display:inline"
                          onsubmit="return confirm('Hapus data ini?')">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="submit"
                            style="background:none; border:none; color:#e53935; font-size:12px; font-weight:700; cursor:pointer;">Hapus</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            
            <?php $__currentLoopData = [
                ['1', '19/04/2025', 'Kebakaran Hutan', 'Luar Bandara', 'Alpha'],
                ['2', '15/04/2025', 'Hujan Deras',     'Runway',       'Alpha'],
                ['3', '03/04/2025', 'Kabut Tebal',     'Runway',       'charlie'],
                ['4', '28/03/2025', 'Bird Strike',     'Runway',       'Bravo'],
                ['5', '24/03/2025', 'Wildlife Hazard', 'Apron',        'Charlie'],
                ['6', '17/03/2025', 'Medis Gawat Darurat', 'Apron',    'Bravo'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($row[0]); ?>.</td>
                <td><?php echo e($row[1]); ?></td>
                <td><?php echo e($row[2]); ?></td>
                <td><?php echo e($row[3]); ?></td>
                <td>
                    <span class="badge <?php echo e($row[4] == 'Alpha' ? 'badge-blue' : ($row[4] == 'Bravo' ? 'badge-orange' : 'badge-green')); ?>">
                        <?php echo e($row[4]); ?>

                    </span>
                </td>
                <td style="text-align:center">
                    <span style="color:var(--blue-main); font-size:12px; font-weight:700; margin-right:8px; cursor:pointer">Detail</span>
                    <span style="color:#e53935; font-size:12px; font-weight:700; cursor:pointer">Hapus</span>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </tbody>
    </table>

    
    <?php if(isset($kejadian) && $kejadian->hasPages()): ?>
    <div class="pagination">
        
        <?php if($kejadian->onFirstPage()): ?>
            <span>‹</span>
        <?php else: ?>
            <a href="<?php echo e($kejadian->previousPageUrl()); ?>">‹</a>
        <?php endif; ?>

        
        <?php for($p = 1; $p <= $kejadian->lastPage(); $p++): ?>
            <?php if($p == $kejadian->currentPage()): ?>
                <span class="active"><?php echo e($p); ?></span>
            <?php else: ?>
                <a href="<?php echo e($kejadian->url($p)); ?>"><?php echo e($p); ?></a>
            <?php endif; ?>
        <?php endfor; ?>

        
        <?php if($kejadian->hasMorePages()): ?>
            <a href="<?php echo e($kejadian->nextPageUrl()); ?>">›</a>
            <a href="<?php echo e($kejadian->nextPageUrl()); ?>" class="btn-next">Selanjutnya</a>
        <?php else: ?>
            <span>›</span>
        <?php endif; ?>
    </div>
    <?php else: ?>
    
    <div class="pagination">
        <span class="active">1</span>
        <a href="#">2</a>
        <a href="#">3</a>
        <a href="#">›</a>
        <a href="#" class="btn-next">Selanjutnya</a>
    </div>
    <?php endif; ?>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.sigap', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sigap\resources\views/data-kejadian.blade.php ENDPATH**/ ?>