<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKejadianRequest;
use App\Models\Kejadian;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SigapController extends Controller
{
    public function dashboard()
    {
        $tahun = now()->year;
        $query = $this->kejadianQueryForCurrentUser();

        $totalKejadian = (clone $query)->count();
        $totalBulanIni = (clone $query)->whereMonth('tanggal_waktu', now()->month)
            ->whereYear('tanggal_waktu', $tahun)
            ->count();
        $kejadianTerbaru = (clone $query)->latest('tanggal_waktu')->take(5)->get();
        $chartData = $this->monthlyCountsForYear($tahun);

        return view('dashboard', compact('totalKejadian', 'totalBulanIni', 'kejadianTerbaru', 'chartData'));
    }

    public function input()
    {
        return view('input');
    }

    public function store(StoreKejadianRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('kejadian', 'public');
        }

        $validated['user_id'] = $request->user()->id;

        Kejadian::create($validated);

        return redirect()
            ->route('data-kejadian')
            ->with('success', 'Laporan kejadian berhasil disimpan!');
    }

    public function dataKejadian(Request $request)
    {
        $query = $this->kejadianQueryForCurrentUser()->latest('tanggal_waktu');

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($builder) use ($q) {
                $builder->where('jenis_kejadian', 'like', "%{$q}%")
                    ->orWhere('lokasi', 'like', "%{$q}%")
                    ->orWhere('nama_personel', 'like', "%{$q}%");
            });
        }

        $kejadian = $query->paginate(6)->withQueryString();

        return view('data-kejadian', compact('kejadian'));
    }

    public function show(Kejadian $kejadian)
    {
        $this->authorizeKejadianAccess($kejadian);

        return view('data-kejadian-detail', compact('kejadian'));
    }

    public function destroy(Kejadian $kejadian)
    {
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
        $colors = ['#4472C4', '#F5821F', '#28A745', '#E53935', '#9C27B0'];

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

        $jenisKejadianList = $totalsByJenis->keys()->take(5)->values();
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
        $query = Kejadian::query();

        if (! request()->user()->isAdmin()) {
            $query->where('user_id', request()->user()->id);
        }

        return $query;
    }

    private function authorizeKejadianAccess(Kejadian $kejadian): void
    {
        if (! request()->user()->isAdmin() && $kejadian->user_id !== request()->user()->id) {
            abort(403);
        }
    }
}
