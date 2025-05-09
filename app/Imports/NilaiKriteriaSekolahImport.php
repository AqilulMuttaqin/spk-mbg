<?php

namespace App\Imports;

use App\Models\Kriteria;
use App\Models\NilaiKriteriaSekolah;
use App\Models\Sekolah;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Facades\Excel;

class NilaiKriteriaSekolahImport
{
    public function import($file)
    {
        $data = Excel::toArray([], $file)[0];
        
        $kriteriaSekolah = Kriteria::where('kategori', 'sekolah')->get();

        $headColumn = $data[0];
        $sekolahColumn = array_search('Sekolah', $headColumn);
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

        foreach ($kriteriaSekolah as $kriteria) {
            ${'kriteria' . $kriteria->id . 'Column'} = array_search($kriteria->nama_kriteria, $headColumn);
        }

        $importedCount = 0;
        $skippedRows = [];

        foreach ($data as $key => $row) {
            if ($key === 0) {
                continue;
            }

            $sekolah = $row[$sekolahColumn];
            $kelurahan = $row[$kelurahanColumn];
            $kecamatan = $row[$kecamatanColumn];
            $sekolahData = Sekolah::where('nama_sekolah', $sekolah)
                ->whereHas('wilayahKelurahan', function ($query) use ($kelurahan, $kecamatan) {
                    $query->where('nama_kelurahan', $kelurahan)
                        ->whereHas('wilayahKecamatan', function ($query) use ($kecamatan) {
                            $query->where('nama_kecamatan', $kecamatan);
                        });
                })
                ->first();

            if (empty($sekolah) || empty($kelurahan) || empty($kecamatan) || !$sekolahData) {
                $skippedRows[] = [
                    'row' => $key + 1, 
                    'reason' => 'Sekolah tidak ditemukan',
                    'type' => 'sekolah'
                ];
                continue;
            }

            foreach ($kriteriaSekolah as $kriteria) {
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

                NilaiKriteriaSekolah::updateOrCreate(
                    [
                        'sekolah_id' => $sekolahData->id,
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
