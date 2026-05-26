<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kejadian</title>

    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        .header-table {
            width: 100%;
            margin-bottom: 25px;
            border: none;
        }

        .header-table td {
            border: none;
            vertical-align: middle;
        }

        .logo {
            width: 90px;
        }

        .title-cell {
            text-align: center;
            padding-right: 90px;
        }

        .title {
            font-size: 28px;
            font-weight: bold;
            margin: 0;
        }

        .subtitle {
            font-size: 14px;
            color: #555;
            margin-top: 6px;
        }

        .info {
            margin-bottom: 15px;
            font-size: 13px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }

        th {
            background: #eeeeee;
            text-align: center;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <table class="header-table">
        <tr>
            <td width="100">
                <img src="<?php echo e(public_path('/images/logo website.png')); ?>" class="logo">
            </td>

            <td class="title-cell">
                <div class="title">Laporan Kejadian SIGAP</div>

                <div class="subtitle">
                    Sistem Informasi Gangguan dan Pelaporan
                </div>
            </td>
        </tr>
    </table>

    <!-- INFO -->
    <div class="info">
        Total Laporan: <strong><?php echo e($laporan->count()); ?></strong>
    </div>

    <!-- TABLE -->
    <table>
        <thead>
            <tr>
                <th width="35">No</th>
                <th>Kronologi</th>
                <th width="120">Jenis Gangguan</th>
                <th width="90">Lokasi</th>
                <th width="120">Tanggal</th>
                <th width="80">Status</th>
            </tr>
        </thead>

        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $laporan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td style="text-align:center;">
                        <?php echo e($loop->iteration); ?>

                    </td>

                    <td>
                        <?php echo e($item->kronologi); ?>

                    </td>

                    <td>
                        <?php echo e($item->jenis_kejadian); ?>

                    </td>

                    <td>
                        <?php echo e($item->lokasi); ?>

                    </td>

                    <td>
                        <?php echo e(\Carbon\Carbon::parse($item->tanggal_waktu)->format('d/m/Y H:i')); ?>

                    </td>

                    <td style="text-align:center;">
                        Tercatat
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

</body>
</html><?php /**PATH C:\laragon\www\sigap\resources\views/laporan/pdf.blade.php ENDPATH**/ ?>