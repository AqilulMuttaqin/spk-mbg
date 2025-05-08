<?php

namespace App\Imports;

use App\Models\Kriteria;
use App\Models\NilaiKriteriaWilayah;
use App\Models\WilayahKelurahan;
use Maatwebsite\Excel\Facades\Excel;

class NilaiKriteriaWilayahImport
{
    public function import($file)
    {
        $data = Excel::toArray([], $file)[0];
        
        $kriteriaWilayah = Kriteria::where('kategori', 'wilayah')->get();

        $headColumn = $data[0];
        $kelurahanColumn = array_search('Kelurahan', $headColumn);
        $kecamatanColumn = array_search('Kecamatan', $headColumn);

        $konversiHurufKeAngka = [
            'A' => 5,
            'B' => 4,
            'C' => 3,
            'D' => 2,
            'E' => 1,
        ];
        $allowedNonAngka = ['A', 'B', 'C', 'D', 'E'];

        foreach ($kriteriaWilayah as $kriteria) {
            ${'kriteria' . $kriteria->id . 'Column'} = array_search($kriteria->nama_kriteria, $headColumn);
        }

        $importedCount = 0;
        $skippedRows = [];

        foreach ($data as $key => $row) {
            if ($key === 0) {
                continue;
            }

            $kelurahan = $row[$kelurahanColumn];
            $kecamatan = $row[$kecamatanColumn];
            $wilayahKelurahan = WilayahKelurahan::where('nama_kelurahan', $kelurahan)
                ->whereHas('wilayahKecamatan', function ($query) use ($kecamatan) {
                    $query->where('nama_kecamatan', $kecamatan);
                })
                ->first();

            if (empty($kelurahan) || empty($kecamatan) || !$wilayahKelurahan) {
                $skippedRows[] = [
                    'row' => $key + 1, 
                    'reason' => 'Wilayah tidak ditemukan',
                    'type' => 'wilayah'
                ];
                continue;
            }

            foreach ($kriteriaWilayah as $kriteria) {
                $value = $row[${'kriteria' . $kriteria->id . 'Column'}];

                $nilai = null;
                $nilaiNonAngka = null;
                $isValid = true;
                $reason = '';

                if ($value !== '') {
                    if ($kriteria->tipe === 'angka') {
                        if (is_numeric($value)) {
                            $nilai = (float)$value;
                        } else {
                            $isValid = false;
                            $reason = "Nilai harus angka";
                        }
                    } else {
                        $valueUpper = strtoupper($value);
                        if (in_array($valueUpper, $allowedNonAngka)) {
                            $nilaiNonAngka = $valueUpper;
                            $nilai = $konversiHurufKeAngka[$valueUpper];
                        } else {
                            $isValid = false;
                            $reason = "Nilai harus A, B, C, D, atau E";
                        }
                    }
                }

                if (!$isValid) {
                    $skippedRows[] = [
                        'row' => $key + 1,
                        'reason' => $reason,
                        'kriteria' => $kriteria->nama_kriteria,
                        'type' => 'nilai'
                    ];
                    continue;
                }

                NilaiKriteriaWilayah::updateOrCreate(
                    [
                        'wilayah_kelurahan_id' => $wilayahKelurahan->id,
                        'kriteria_id' => $kriteria->id,
                    ],
                    [
                        'nilai' => $nilai,
                        'nilai_non_angka' => $nilaiNonAngka,
                    ]
                );
            }
            $importedCount++;
        }

        return [
            'imported_count' => $importedCount,
            'skipped_rows' => $skippedRows
        ];
    }
}