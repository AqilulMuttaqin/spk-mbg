<?php

namespace App\Exports;

use App\Models\Kriteria;
use App\Models\NilaiKriteriaWilayah;
use App\Models\WilayahKelurahan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FormatNilaiKriteriaWilayahExport implements FromView, WithStyles, ShouldAutoSize
{
    public function view(): View
    {
        $kelurahan = WilayahKelurahan::with('wilayahKecamatan')->get();
        $kriteriaWilayah = Kriteria::where('kategori', 'wilayah')->get();
        $nilaiKriteria = NilaiKriteriaWilayah::all();

        $data = $kelurahan->map(function ($kelurahan) use ($kriteriaWilayah, $nilaiKriteria) {
            $row = [
                'kelurahan' => $kelurahan->nama_kelurahan,
                'kecamatan' => $kelurahan->wilayahKecamatan->nama_kecamatan,
            ];

            foreach ($kriteriaWilayah as $kriteria) {
                $nilai = $nilaiKriteria->where('wilayah_kelurahan_id', $kelurahan->id)
                    ->where('kriteria_id', $kriteria->id)
                    ->first();

                $row[$kriteria->nama_kriteria] = $nilai ? ($kriteria->tipe === 'angka' ? $nilai->nilai : $nilai->nilai_non_angka) : '';
            }

            return $row;
        });

        return view('wilayah.nilai-kriteria-wilayah.format-import', [
            'data' => $data,
            'kriteria' => $kriteriaWilayah,
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:'.$sheet->getHighestColumn().'1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFD700'], // Warna kuning
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
        ]);

        $sheet->getStyle('A1:'.$sheet->getHighestColumn().$sheet->getHighestRow())->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
        ]);
    }
}