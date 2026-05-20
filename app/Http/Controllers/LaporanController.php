<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kejadian;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;


class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $laporan = $this->filterLaporan($request);

        return view('laporan.index', compact('laporan'));
    }

    public function pdf(Request $request)
    {
        $laporan = $this->filterLaporan($request);

        $pdf = Pdf::loadView('laporan.pdf', compact('laporan'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-kejadian.pdf');
    }

    public function excel(Request $request)
    {
        $laporan = $this->filterLaporan($request);

        return Excel::download(
        new LaporanExport,
        'laporan-kejadian.xlsx'
     );
    }

    private function filterLaporan(Request $request)
    {
        $query = Kejadian::query();

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal_waktu', [
                $request->tanggal_awal . ' 00:00:00',
                $request->tanggal_akhir . ' 23:59:59'
            ]);
        }

        if ($request->filled('jenis_gangguan')) {
            $query->where('jenis_kejadian', $request->jenis_gangguan);
        }

        return $query->latest('tanggal_waktu')->get();
    }
}