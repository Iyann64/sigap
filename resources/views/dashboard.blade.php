@extends('layouts.sigap')

@section('title', 'Dashboard')

@section('content')
<div class="page-title">
    <span></span> Dashboard
</div>

<!-- STAT CARDS -->
<div class="stat-cards">
    <div class="stat-card green">
        <div class="label">Total Kejadian</div>
        <div class="value">{{ $totalKejadian ?? 0 }}</div>
    </div>

    <div class="stat-card blue">
        <div class="label">Total Kejadian Bulan Ini</div>
        <div class="value">{{ $totalBulanIni ?? 0 }}</div>
    </div>

    <div class="stat-card orange">
        <div class="label">Total Kejadian Tahun Ini</div>
        <div class="value">{{ $totalTahunIni ?? 0 }}</div>
    </div>
</div>

<!-- CHART -->
<div class="card">
    <div class="card-title">Grafik Tren Kejadian</div>
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
            @forelse($statistikKategori ?? [] as $item)
                <tr>
                    <td>{{ $item->jenis_kejadian }}</td>
                    <td style="text-align:center; font-weight:700;">
                        {{ $item->total }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" style="text-align:center;">
                        Belum ada data kategori gangguan.
                    </td>
                </tr>
            @endforelse
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
            @forelse($kejadianTerbaru ?? [] as $item)
                <tr>
                    <td>{{ $item->tanggal_waktu->format('d/m/Y') }}</td>
                    <td>{{ $item->jenis_kejadian }}</td>
                    <td>{{ Str::limit($item->kronologi, 50) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align:center;">
                        Belum ada data kejadian terbaru.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

<script>
const chartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

const chartValues = <?php echo json_encode($chartData ?? [0,0,0,0,0,0,0,0,0,0,0,0]); ?>;

// DATA DONUT
const kategoriLabels = <?php echo json_encode(($statistikKategori ?? collect())->pluck('jenis_kejadian')); ?>;

const kategoriValues = <?php echo json_encode(($statistikKategori ?? collect())->pluck('total')); ?>;

document.addEventListener('DOMContentLoaded', function () {

    // BAR CHART
    const ctx = document.getElementById('chartTren');

    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Jumlah Kejadian',
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
@endpush