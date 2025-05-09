<?php

namespace App\Exports;

use App\Models\Kriteria;
use App\Models\NilaiKriteriaSekolah;
use App\Models\Sekolah;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FormatNilaiKriteriaSekolahExport implements FromView, WithStyles, ShouldAutoSize
{
    public function view(): View
    {
        $sekolah = Sekolah::with(['wilayahKelurahan', 'wilayahKelurahan.wilayahKecamatan'])->get();
        $kriteriaSekolah = Kriteria::where('kategori', 'sekolah')->get();
        $nilaiKriteria = NilaiKriteriaSekolah::all();

        $data = $sekolah->map(function ($sek, $index) use ($kriteriaSekolah, $nilaiKriteria) {
            $row = [
                'sekolah' => $sek->nama_sekolah,
                'kelurahan' => $sek->wilayahKelurahan->nama_kelurahan,
                'kecamatan' => $sek->wilayahKelurahan->wilayahKecamatan->nama_kecamatan,
            ];

            foreach ($kriteriaSekolah as $kriteria) {
                $nilai = $nilaiKriteria->where('sekolah_id', $sek->id)
                    ->where('kriteria_id', $kriteria->id)
                    ->first();
                
                $row[$kriteria->nama_kriteria] = $nilai ? ($kriteria->tipe === 'angka' ? $nilai->nilai : $nilai->nilai_non_angka) : '';
            }

            return $row;
        });

        return view('sekolah.nilai-kriteria-sekolah.format-import', [
            'data' => $data,
            'kriteria' => $kriteriaSekolah,
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
                'color' => ['rgb' => 'FFD700'],
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