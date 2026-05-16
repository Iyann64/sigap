<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kejadian;

class SigapController extends Controller
{
    // ─── Dashboard ────────────────────────────────────────────────────
    public function dashboard()
    {
        $totalKejadian  = Kejadian::count();
        $totalBulanIni  = Kejadian::whereMonth('tanggal_waktu', now()->month)
                                  ->whereYear('tanggal_waktu', now()->year)
                                  ->count();
        $kejadianTerbaru = Kejadian::latest('tanggal_waktu')->take(5)->get();

        // Data chart: jumlah per bulan (tahun ini)
        $chartData = [];
        for ($m = 1; $m <= 12; $m++) {
            $chartData[] = Kejadian::whereMonth('tanggal_waktu', $m)
                                   ->whereYear('tanggal_waktu', now()->year)
                                   ->count();
        }

        return view('dashboard', compact('totalKejadian', 'totalBulanIni', 'kejadianTerbaru', 'chartData'));
    }

    // ─── Input Laporan ────────────────────────────────────────────────
    public function input()
    {
        return view('input');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_kejadian' => 'required|string|max:100',
            'kronologi'      => 'required|string',
            'lokasi'         => 'required|string|max:100',
            'tanggal_waktu'  => 'required|date',
            'foto'           => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'nama_personel'  => 'required|string|max:150',
            'regu'           => 'required|string|max:50',
            'shift'          => 'required|string|max:50',
        ]);

        // Handle upload foto
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('kejadian', 'public');
        }

        Kejadian::create($validated);

        return redirect()->route('data-kejadian')
                         ->with('success', 'Laporan kejadian berhasil disimpan!');
    }

    // ─── Data Kejadian ────────────────────────────────────────────────
    public function dataKejadian(Request $request)
    {
        $query = Kejadian::latest('tanggal_waktu');

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($builder) use ($q) {
                $builder->where('jenis_kejadian', 'like', "%{$q}%")
                        ->orWhere('lokasi',        'like', "%{$q}%")
                        ->orWhere('nama_personel', 'like', "%{$q}%");
            });
        }

        $kejadian = $query->paginate(6)->withQueryString();

        return view('data-kejadian', compact('kejadian'));
    }

    public function show($id)
    {
        $kejadian = Kejadian::findOrFail($id);
        return view('data-kejadian-detail', compact('kejadian'));
    }

    public function destroy($id)
    {
        Kejadian::findOrFail($id)->delete();
        return redirect()->route('data-kejadian')
                         ->with('success', 'Data berhasil dihapus.');
    }

    // ─── Grafik ───────────────────────────────────────────────────────
    public function grafik(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));

        // Ambil semua jenis kejadian unik
        $jenisKejadianList = Kejadian::whereYear('tanggal_waktu', $tahun)
                                     ->distinct()
                                     ->pluck('jenis_kejadian')
                                     ->take(5); // batasi 5 kategori

        $colors = ['#4472C4', '#F5821F', '#28A745', '#E53935', '#9C27B0'];

        $chartDatasets = [];
        foreach ($jenisKejadianList as $idx => $jenis) {
            $data = [];
            for ($m = 1; $m <= 12; $m++) {
                $data[] = Kejadian::where('jenis_kejadian', $jenis)
                                  ->whereMonth('tanggal_waktu', $m)
                                  ->whereYear('tanggal_waktu', $tahun)
                                  ->count();
            }
            $chartDatasets[] = [
                'label'           => $jenis,
                'data'            => $data,
                'backgroundColor' => $colors[$idx % count($colors)],
                'borderRadius'    => 4,
            ];
        }

        // Summary total per jenis
        $summary = [];
        foreach ($jenisKejadianList as $idx => $jenis) {
            $summary[] = [
                'label' => $jenis,
                'total' => Kejadian::where('jenis_kejadian', $jenis)
                                   ->whereYear('tanggal_waktu', $tahun)
                                   ->count(),
                'color' => $colors[$idx % count($colors)],
            ];
        }

        return view('grafik', compact('chartDatasets', 'summary', 'tahun'));
    }
}