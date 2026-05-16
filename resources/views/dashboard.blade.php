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
        <div class="value">{{ $totalKejadian ?? 125 }}</div>
    </div>
    <div class="stat-card blue">
        <div class="label">Total Kejadian Bulan Ini</div>
        <div class="value">{{ $totalBulanIni ?? 23 }}</div>
    </div>
</div>

<!-- CHART -->
<div class="card">
    <div class="card-title">Grafik Tren Kejadian</div>
    <div class="chart-container">
        <canvas id="chartTren"></canvas>
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
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_waktu)->format('d/m/Y') }}</td>
                    <td>{{ $item->jenis_kejadian }}</td>
                    <td>{{ Str::limit($item->kronologi, 50) }}</td>
                </tr>
            @empty
                <tr>
                    <td>13/04/2024</td>
                    <td>Kebakaran Hutan</td>
                    <td>12.36</td>
                </tr>
                <tr>
                    <td>12/04/2025</td>
                    <td>Animal Hazard</td>
                    <td>05.24</td>
                </tr>
                <tr>
                    <td>18/04/2025</td>
                    <td>Hujan Deras</td>
                    <td>16.47</td>
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
const chartValues = <?php echo json_encode($chartData ?? [12, 20, 24, 15, 30, 35, 8, 12, 30, 14, 22, 0]); ?>;

document.addEventListener('DOMContentLoaded', function() {
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
                            font: { family: 'Nunito', size: 12 }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: 'Nunito', size: 11 } }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 10, font: { family: 'Nunito', size: 11 } }
                    }
                }
            }
        });
    }
});
</script>
@endpush