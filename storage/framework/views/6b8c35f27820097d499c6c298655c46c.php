<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-title">
    <span></span> Dashboard
</div>

<!-- STAT CARDS -->
<div class="stat-cards">
    <div class="stat-card green">
        <div class="label">Total Kejadian</div>
        <div class="value"><?php echo e($totalKejadian ?? 0); ?></div>
    </div>

    <div class="stat-card blue">
        <div class="label">Total Kejadian Bulan Ini</div>
        <div class="value"><?php echo e($totalBulanIni ?? 0); ?></div>
    </div>

    <div class="stat-card orange">
        <div class="label">Total Kejadian Tahun Ini</div>
        <div class="value"><?php echo e($totalTahunIni ?? 0); ?></div>
    </div>
</div>

<!-- CHART -->
<div id="aktivitas-user" class="card">
    <div style="display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap; margin-bottom:14px;">
        <div class="card-title" style="margin-bottom:0;">Grafik Tren Kejadian</div>
        <form method="GET" action="<?php echo e(route('dashboard')); ?>" style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
            <label style="font-size:13px; font-weight:700; color:var(--text-mid);">Tahun</label>
            <select name="tahun" class="form-control" style="width:120px;" onchange="this.form.submit();">
                <?php for($y = date('Y'); $y >= date('Y') - 5; $y--): ?>
                    <option value="<?php echo e($y); ?>" <?php echo e(($tahun ?? date('Y')) == $y ? 'selected' : ''); ?>><?php echo e($y); ?></option>
                <?php endfor; ?>
            </select>
        </form>
    </div>
    <div class="chart-container">
        <canvas id="chartTren"></canvas>
    </div>
</div>

<!-- STATISTIK KATEGORI -->
<div class="card">
    <div class="card-title">Statistik Berdasarkan Kategori Gangguan</div>

    <table>
        <thead>
            <tr>
                <th>Kategori Gangguan</th>
                <th style="width:120px; text-align:center;">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $statistikKategori ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($item->jenis_kejadian); ?></td>
                    <td style="text-align:center; font-weight:700;">
                        <?php echo e($item->total); ?>

                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="2" style="text-align:center;">
                        Belum ada data kategori gangguan.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- PIE / DONUT KATEGORI -->
<div class="card">
    <div class="card-title">Grafik Kategori Kejadian</div>
    <div class="chart-container">
        <canvas id="chartKategori"></canvas>
    </div>
</div>

<!-- RECENT TABLE -->
<div class="card">
    <div class="card-title">Kejadian Terbaru</div>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jenis Kejadian</th>
                <th>Isi</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $kejadianTerbaru ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($item->tanggal_waktu->format('d/m/Y')); ?></td>
                    <td><?php echo e($item->jenis_kejadian); ?></td>
                    <td><?php echo e(Str::limit($item->kronologi, 50)); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="3" style="text-align:center;">
                        Belum ada data kejadian terbaru.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if(auth()->user()->isAdmin()): ?>
<div class="card">
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; gap:12px; flex-wrap:wrap;">
        <div class="card-title" style="margin-bottom:0;">Aktivitas User Terbaru</div>
        <?php if(isset($activityLogs) && method_exists($activityLogs, 'total')): ?>
            <div class="table-meta">
                Menampilkan
                <strong><?php echo e($activityLogs->firstItem() ?? 0); ?></strong>
                sampai
                <strong><?php echo e($activityLogs->lastItem() ?? 0); ?></strong>
                dari
                <strong><?php echo e($activityLogs->total() ?? 0); ?></strong>
                aktivitas
            </div>
        <?php endif; ?>
    </div>
    <table>
        <thead>
            <tr>
                <th>Waktu</th>
                <th>User</th>
                <th>Aktivitas</th>
                <th>IP</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $activityLogs ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($log->created_at->format('d/m/Y H:i')); ?></td>
                    <td>
                        <?php echo e($log->user?->name ?? 'User terhapus'); ?>

                        <?php if($log->user?->role): ?>
                            <span class="badge badge-blue"><?php echo e($log->user->role); ?></span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo e($log->description); ?></td>
                    <td><?php echo e($log->ip_address ?? '-'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="4" style="text-align:center;">
                        Belum ada aktivitas user.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php if(isset($activityLogs) && method_exists($activityLogs, 'hasPages') && $activityLogs->hasPages()): ?>
        <div style="margin-top:20px; display:flex; justify-content:center;">
            <?php echo e($activityLogs->fragment('aktivitas-user')->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

<script>
const chartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

const chartValues = <?php echo json_encode($chartData ?? [0,0,0,0,0,0,0,0,0,0,0,0]); ?>;

// DATA DONUT
const kategoriLabels = <?php echo json_encode(($statistikKategori ?? collect())->pluck('jenis_kejadian')); ?>;

const kategoriValues = <?php echo json_encode(($statistikKategori ?? collect())->pluck('total')); ?>;

document.addEventListener('DOMContentLoaded', function () {
    const activityPanel = document.getElementById('aktivitas-user');

    function scrollToActivityPanel() {
        if (!activityPanel) {
            return;
        }

        const header = document.querySelector('.header');
        const headerOffset = header ? header.offsetHeight + 16 : 16;
        const top = activityPanel.getBoundingClientRect().top + window.pageYOffset - headerOffset;

        window.scrollTo({ top, behavior: 'auto' });
    }

    activityPanel?.querySelectorAll('a[href*="activity_page="]').forEach(function (link) {
        link.addEventListener('click', function () {
            sessionStorage.setItem('scrollToActivityPanel', '1');
        });
    });

    const shouldScrollToActivity =
        window.location.hash === '#aktivitas-user'
        || new URLSearchParams(window.location.search).has('activity_page')
        || sessionStorage.getItem('scrollToActivityPanel') === '1';

    if (shouldScrollToActivity) {
        sessionStorage.removeItem('scrollToActivityPanel');
        window.addEventListener('load', function () {
            setTimeout(scrollToActivityPanel, 150);
            setTimeout(scrollToActivityPanel, 500);
        });
    }

    // BAR CHART
    const ctx = document.getElementById('chartTren');

    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: "Jumlah Kejadian <?php echo e($tahun ?? date('Y')); ?>",
                    data: chartValues,
                    backgroundColor: '#F5821F',
                    borderRadius: 5,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: {
                                family: 'Nunito',
                                size: 12
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                family: 'Nunito',
                                size: 11
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 10,
                            font: {
                                family: 'Nunito',
                                size: 11
                            }
                        }
                    }
                }
            }
        });
    }

    // DONUT CHART
    const ctxKategori = document.getElementById('chartKategori');

    if (ctxKategori) {
        new Chart(ctxKategori, {
            type: 'doughnut',
            data: {
                labels: kategoriLabels,
                datasets: [{
                    data: kategoriValues,
                    backgroundColor: [
                        '#F5821F',
                        '#4472C4',
                        '#28A745',
                        '#E53935',
                        '#9C27B0',
                        '#00ACC1',
                        '#FFC107'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: {
                                family: 'Nunito',
                                size: 12
                            }
                        }
                    }
                }
            }
        });
    }

});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.sigap', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sigap\resources\views/dashboard.blade.php ENDPATH**/ ?>