<?php

namespace App\Exports;

use App\Models\Kejadian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class LaporanExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        return Kejadian::latest('tanggal_waktu')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Jenis Gangguan',
            'Lokasi',
            'Kronologi',
            'Status',
        ];
    }

    public function map($item): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            Carbon::parse($item->tanggal_waktu)->format('d/m/Y H:i'),
            $item->jenis_kejadian,
            $item->lokasi,
            $item->kronologi,
            'Tercatat',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);
        $sheet->getStyle('A1:F1')->getAlignment()->setHorizontal('center');

        $sheet->getStyle('A:F')->getAlignment()->setVertical('top');
        $sheet->getStyle('A:F')->getAlignment()->setWrapText(true);

        $sheet->getColumnDimension('A')->setWidth(8);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(60);
        $sheet->getColumnDimension('F')->setWidth(15);

        return [];
    }
}