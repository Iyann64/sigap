@extends('layouts.sigap')

@section('title', 'Grafik')

@section('content')
<div class="page-title">
    <span></span> Grafik Kejadian
</div>

<!-- Filter tahun -->
<div class="card" style="margin-bottom: 20px;">
    <form method="GET" action="{{ route('grafik') }}" style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
        <label style="font-size: 13px; font-weight: 700; color: var(--text-mid);">Filter Tahun:</label>
        <select name="tahun" class="form-control" style="width: 120px;" onchange="this.form.submit();">
            @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                <option value="{{ $y }}" {{ (request('tahun', date('Y')) == $y) ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>
        <span style="font-size: 12px; color: var(--text-light);">Menampilkan data tahun {{ request('tahun', date('Y')) }}</span>
    </form>
</div>

<!-- Grouped Bar Chart -->
<div class="card">
    <div class="card-title">Perbandingan Jenis Kejadian per Bulan</div>
    <div class="chart-container" style="height: 300px;">
        <canvas id="chartGrafik"></canvas>
    </div>
</div>

<!-- Summary cards -->
<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-top: 20px;">
    @php
        $summaryData = $summary ?? [
            ['label' => 'Kebakaran Hutan', 'total' => 18, 'color' => '#4472C4'],
            ['label' => 'Hujan Lebat', 'total' => 24, 'color' => '#F5821F'],
            ['label' => 'Wildlife Hazard', 'total' => 12, 'color' => '#28A745'],
        ];
    @endphp
    @foreach($summaryData as $s)
        <div class="card" style="margin-bottom: 0; display: flex; align-items: center; gap: 14px;">
            <div style="width: 10px; height: 44px; border-radius: 4px; background: {{ $s['color'] }}; flex-shrink: 0;"></div>
            <div>
                <div style="font-size: 11.5px; color: var(--text-light); font-weight: 600;">{{ $s['label'] }}</div>
                <div style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 26px; font-weight: 800; color: var(--text-dark);">{{ $s['total'] }}</div>
            </div>
        </div>
    @endforeach
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
const chartMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

const chartDatasets = [
    {
        label: 'Kebakaran Hutan',
        data: [2, 3, 3, 4, 1, 2, 3, 5, 2, 2, 4, 3],
        backgroundColor: '#4472C4',
        borderRadius: 4
    },
    {
        label: 'Hujan Lebat',
        data: [3, 2, 2, 5, 4, 3, 5, 3, 4, 2, 2, 3],
        backgroundColor: '#F5821F',
        borderRadius: 4
    },
    {
        label: 'Wildlife Hazard',
        data: [1, 2, 2, 2, 3, 1, 2, 3, 2, 2, 2, 2],
        backgroundColor: '#28A745',
        borderRadius: 4
    }
];

document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('chartGrafik');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartMonths,
                datasets: chartDatasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: { family: 'Nunito', size: 12 },
                            padding: 18
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
                        ticks: { stepSize: 5, font: { family: 'Nunito', size: 11 } },
                        grid: { color: 'rgba(0, 0, 0, 0.05)' }
                    }
                }
            }
        });
    }
});
</script>
@endpush
