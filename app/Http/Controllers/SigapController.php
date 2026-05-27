<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKejadianRequest;
use App\Models\ActivityLog;
use App\Models\Kejadian;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SigapController extends Controller
{
    public function dashboard(Request $request)
    {
        $tahun = (int) $request->get('tahun', now()->year);
        if ($tahun < 2000 || $tahun > now()->year + 5) {
            $tahun = now()->year;
        }

        $query = $this->kejadianQueryForCurrentUser();
        $tahunIni = now()->year;

        $totalKejadian = (clone $query)->count();

        $totalBulanIni = (clone $query)
            ->whereMonth('tanggal_waktu', now()->month)
            ->whereYear('tanggal_waktu', $tahun)
            ->count();

        $totalTahunIni = (clone $query)
            ->whereYear('tanggal_waktu', $tahun)
            ->count();

        // Statistik kategori gangguan
        $statistikKategori = (clone $query)
            ->select('jenis_kejadian')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('jenis_kejadian')
            ->orderByDesc('total')
            ->get();

        $kejadianTerbaru = (clone $query)
            ->latest('tanggal_waktu')
            ->take(5)
            ->get();

        $chartData = $this->monthlyCountsForYear($tahun);
        $activityLogs = request()->user()->isAdmin()
            ? ActivityLog::with('user')
                ->latest()
                ->paginate(6, ['*'], 'activity_page')
                ->withQueryString()
            : collect();

        return view('dashboard', compact(
            'totalKejadian',
            'totalBulanIni',
            'totalTahunIni',
            'statistikKategori',
            'kejadianTerbaru',
            'chartData',
            'tahun',
            'activityLogs'
        ));
    }

    public function input()
    {
        return view('input');
    }

    public function store(StoreKejadianRequest $request)
    {
        $validated = $request->validated();

        $validated = $this->normalizeJenisKejadian($validated);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('kejadian', 'public');
        }

        $validated['user_id'] = $request->user()->id;

        $kejadian = Kejadian::create($validated);
        ActivityLog::record('kejadian.created', 'Membuat laporan kejadian: ' . $kejadian->jenis_kejadian, $kejadian, $request);

        return redirect()
            ->route('data-kejadian')
            ->with('success', 'Laporan kejadian berhasil disimpan!');
    }

    public function edit(Kejadian $kejadian)
    {
        $this->authorizeKejadianAccess($kejadian);
        return view('data-kejadian-edit', compact('kejadian'));
    }

    public function update(StoreKejadianRequest $request, Kejadian $kejadian)
    {
        $this->authorizeKejadianAccess($kejadian);
        $validated = $request->validated();

        $validated = $this->normalizeJenisKejadian($validated);

        if ($request->hasFile('foto')) {
            if ($kejadian->foto) {
                Storage::disk('public')->delete($kejadian->foto);
            }
            $validated['foto'] = $request->file('foto')->store('kejadian', 'public');
        }

        $kejadian->update($validated);
        ActivityLog::record('kejadian.updated', 'Mengedit laporan kejadian: ' . $kejadian->jenis_kejadian, $kejadian, $request);

        return redirect()
            ->route('data-kejadian')
            ->with('success', 'Laporan kejadian berhasil diperbarui!');
    }

    public function dataKejadian(Request $request)
    {
        $query = Kejadian::query()->latest('tanggal_waktu');
        $tahun = (int) $request->get('tahun', now()->year);
        if ($tahun < 2000 || $tahun > now()->year + 5) {
            $tahun = now()->year;
        }

        $query->whereYear('tanggal_waktu', $tahun);

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($builder) use ($q) {
                $builder->where('jenis_kejadian', 'like', "%{$q}%")
                    ->orWhere('lokasi', 'like', "%{$q}%")
                    ->orWhere('nama_personel', 'like', "%{$q}%");
            });
        }

        $kejadian = $query->paginate(6)->withQueryString();

        return view('data-kejadian', compact('kejadian', 'tahun'));
    }

    public function show(Kejadian $kejadian)
    {
        return view('data-kejadian-detail', compact('kejadian'));
    }

    public function destroy(Kejadian $kejadian)
    {
        ActivityLog::record('kejadian.deleted', 'Menghapus laporan kejadian: ' . $kejadian->jenis_kejadian, $kejadian);

        if ($kejadian->foto) {
            Storage::disk('public')->delete($kejadian->foto);
        }

        $kejadian->delete();

        return redirect()
            ->route('data-kejadian')
            ->with('success', 'Data berhasil dihapus.');
    }

    public function grafik(Request $request)
    {
        $tahun = (int) $request->get('tahun', date('Y'));
        $colors = [
            '#4472C4',
            '#F5821F',
            '#28A745',
            '#E53935',
            '#9C27B0',
            '#00ACC1',
            '#FFC107',
            '#795548',
            '#607D8B',
            '#E91E63',
            '#009688',
            '#3F51B5',
            '#FF5722'
        ];

        $rows = $this->kejadianQueryForCurrentUser()
            ->select('jenis_kejadian')
            ->selectRaw($this->monthExpression() . ' as month')
            ->selectRaw('COUNT(*) as total')
            ->whereYear('tanggal_waktu', $tahun)
            ->groupBy('jenis_kejadian')
            ->groupByRaw($this->monthExpression())
            ->get();

        $totalsByJenis = $rows
            ->groupBy('jenis_kejadian')
            ->map(fn (Collection $items) => (int) $items->sum('total'))
            ->sortDesc();

        $jenisKejadianList = $totalsByJenis->keys()->values();
        $rowsByJenis = $rows->groupBy('jenis_kejadian');

        $chartDatasets = [];
        foreach ($jenisKejadianList as $idx => $jenis) {
            $countsByMonth = $rowsByJenis->get($jenis, collect())->pluck('total', 'month');

            $chartDatasets[] = [
                'label' => $jenis,
                'data' => $this->monthSeries($countsByMonth),
                'backgroundColor' => $colors[$idx % count($colors)],
                'borderRadius' => 4,
            ];
        }

        $summary = [];
        foreach ($jenisKejadianList as $idx => $jenis) {
            $summary[] = [
                'label' => $jenis,
                'total' => $totalsByJenis->get($jenis),
                'color' => $colors[$idx % count($colors)],
            ];
        }

        return view('grafik', compact('chartDatasets', 'summary', 'tahun'));
    }

    private function monthlyCountsForYear(int $tahun): array
    {
        $countsByMonth = $this->kejadianQueryForCurrentUser()
            ->selectRaw($this->monthExpression() . ' as month')
            ->selectRaw('COUNT(*) as total')
            ->whereYear('tanggal_waktu', $tahun)
            ->groupByRaw($this->monthExpression())
            ->pluck('total', 'month');

        return $this->monthSeries($countsByMonth);
    }

    private function monthSeries(Collection $countsByMonth): array
    {
        return collect(range(1, 12))
            ->map(fn (int $month) => (int) $countsByMonth->get($month, 0))
            ->all();
    }

    private function monthExpression(): string
    {
        return match (DB::connection()->getDriverName()) {
            'sqlite' => "CAST(strftime('%m', tanggal_waktu) AS INTEGER)",
            'pgsql' => 'EXTRACT(MONTH FROM tanggal_waktu)',
            default => 'MONTH(tanggal_waktu)',
        };
    }

    private function kejadianQueryForCurrentUser()
    {
        return Kejadian::query();
    }

    private function authorizeKejadianAccess(Kejadian $kejadian): void
    {
        if (! request()->user()->isAdmin() && $kejadian->user_id !== request()->user()->id) {
            abort(403);
        }
    }

    private function normalizeJenisKejadian(array $validated): array
    {
        if ($validated['jenis_kejadian'] === 'Lain Lain') {
            $validated['jenis_kejadian'] = trim($validated['custom_jenis_kejadian']);
        }

        if ($validated['lokasi'] === 'Lain Lain') {
            $validated['lokasi'] = trim($validated['custom_lokasi']);
        }

        unset($validated['custom_jenis_kejadian'], $validated['custom_lokasi']);

        return $validated;
    }
}
