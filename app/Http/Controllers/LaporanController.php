<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Models\Kejadian;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $laporan = $this->filterLaporan($request, true);

        $jenisKejadianOptions = $this->laporanQueryForCurrentUser($request)
            ->select('jenis_kejadian')
            ->distinct()
            ->orderBy('jenis_kejadian')
            ->pluck('jenis_kejadian');

        return view('laporan.index', compact('laporan', 'jenisKejadianOptions'));
    }

    public function pdf(Request $request)
    {
        $laporan = $this->filterLaporan($request, false);

        ActivityLog::record('laporan.pdf', 'Mencetak laporan PDF (' . $laporan->count() . ' data).', null, $request);

        $pdf = Pdf::loadView('laporan.pdf', compact('laporan'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-kejadian.pdf');
    }

    public function excel(Request $request)
    {
        $laporan = $this->filterLaporan($request, false);

        ActivityLog::record('laporan.excel', 'Export laporan Excel (' . $laporan->count() . ' data).', null, $request);

        return Excel::download(
            new LaporanExport($laporan),
            'laporan-kejadian.xlsx'
        );
    }

    private function filterLaporan(Request $request, bool $paginate = false)
    {
        $query = $this->laporanQueryForCurrentUser($request);

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal_waktu', [
                $request->tanggal_awal . ' 00:00:00',
                $request->tanggal_akhir . ' 23:59:59'
            ]);
        }

        if ($request->filled('jenis_kejadian')) {
            $query->where('jenis_kejadian', $request->jenis_kejadian);
        }

        if ($request->filled('lokasi')) {
            $query->where('lokasi', $request->lokasi);
        }

        $query->latest('tanggal_waktu');

        if ($paginate) {
            return $query->paginate(6)->withQueryString();
        }

        return $query->get();
    }

    private function laporanQueryForCurrentUser(Request $request)
    {
        return Kejadian::query();
    }
}
