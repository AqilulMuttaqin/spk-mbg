<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\NilaiKriteriaSekolah;
use App\Models\NilaiKriteriaWilayah;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PerhitunganRekomendasiController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()) {
            $sekolah = Sekolah::with(['wilayahKelurahan', 'wilayahKelurahan.wilayahKecamatan'])->get();
            $kriteria = Kriteria::all();
            $nilaiKriteriaSekolah = NilaiKriteriaSekolah::all();
            $nilaiKriteriaWilayah = NilaiKriteriaWilayah::all();
    
            $data = $sekolah->map(function ($sek, $index) use ($kriteria, $nilaiKriteriaSekolah, $nilaiKriteriaWilayah) {
                $wilayah = 'Kel. ' . $sek->wilayahKelurahan->nama_kelurahan . ', Kec. ' . $sek->wilayahKelurahan->wilayahKecamatan->nama_kecamatan;
                $row = [
                    'alternatif' => 'A ' . $index + 1,
                    'sekolah' => $sek->nama_sekolah,
                    'wilayah' => $wilayah,
                ];
    
                foreach ($kriteria as $k) {
                    if ($k->kategori == 'sekolah') {
                        $nilai = $nilaiKriteriaSekolah->where('sekolah_id', $sek->id)
                                    ->where('kriteria_id', $k->id)
                                    ->first();
                    } else {
                        $nilai = $nilaiKriteriaWilayah->where('wilayah_kelurahan_id', $sek->wilayah_kelurahan_id)
                                    ->where('kriteria_id', $k->id)
                                    ->first();
                    }
    
                    if ($k->tipe == 'angka') {
                        $row[$k->nama_kriteria] = ($nilai && $nilai->nilai !== null) ? $nilai->nilai : '-';
                    } else {
                        $row[$k->nama_kriteria] = ($nilai && $nilai->nilai_non_angka !== null) ? $nilai->nilai_non_angka : '-';
                    }
                }
    
                return $row;
            });

            return DataTables::of($data)->make(true);
        }

        return view('rekomendasi.index', [
            'title' => 'Rekomendasi',
            'kriteria' => Kriteria::all(),
        ]);
    }

    public function perhitungan()
    {
        $sekolah = Sekolah::with(['wilayahKelurahan', 'wilayahKelurahan.wilayahKecamatan'])->get();
        $kriteria = Kriteria::all();
        $nilaiKriteriaSekolah = NilaiKriteriaSekolah::all();
        $nilaiKriteriaWilayah = NilaiKriteriaWilayah::all();

        $data = $sekolah->map(function ($sek, $index) use ($kriteria, $nilaiKriteriaSekolah, $nilaiKriteriaWilayah) {
            $wilayah = 'Kel. ' . $sek->wilayahKelurahan->nama_kelurahan . ', Kec. ' . $sek->wilayahKelurahan->wilayahKecamatan->nama_kecamatan;
            $row = [];

            foreach ($kriteria as $k) {
                if ($k->kategori == 'sekolah') {
                    $nilai = $nilaiKriteriaSekolah->where('sekolah_id', $sek->id)
                                ->where('kriteria_id', $k->id)
                                ->first();
                } else {
                    $nilai = $nilaiKriteriaWilayah->where('wilayah_kelurahan_id', $sek->wilayah_kelurahan_id)
                                ->where('kriteria_id', $k->id)
                                ->first();
                }

                $row[$k->nama_kriteria] = ($nilai && $nilai->nilai !== null) ? $nilai->nilai : '-';

            }

            return $row;
        });

        $normalisasi = [];

        foreach ($kriteria as $k) {
            $namaKriteria = $k->nama_kriteria;

            $nilaiKriteria = $data->pluck($namaKriteria)->map(function ($val) {
                return is_numeric($val) ? floatval($val) : 0;
            });

            $akarJumlahKuadrat = round(sqrt($nilaiKriteria->map(function ($v) {
                return $v * $v;
            })->sum()), 3);

            foreach ($data as $i => $d) {
                $nilai = is_numeric($d[$namaKriteria]) ? floatval($d[$namaKriteria]) : 0;

                if ($akarJumlahKuadrat == 0) {
                    $normalisasi[$i][$namaKriteria] = 0;
                } else {
                    $hasil = $k->sifat == 'cost'
                        ? 1 - ($nilai / $akarJumlahKuadrat)
                        : $nilai / $akarJumlahKuadrat;

                    $normalisasi[$i][$namaKriteria] = round($hasil, 3);
                }
            }
        }

        $bobotTernormalisasi = [];

        foreach ($normalisasi as $i => $baris) {
            foreach ($baris as $namaKriteria => $nilaiNormalisasi) {
                $bobot = $kriteria->where('nama_kriteria', $namaKriteria)->first()?->bobot ?? 0;
                $bobotTernormalisasi[$i][$namaKriteria] = round($nilaiNormalisasi * $bobot, 3);
            }
        }

        $concordanceSet = [];
        $concordanceValue = [];

        $jumlahAlternatif = count($bobotTernormalisasi);

        for ($i = 0; $i < $jumlahAlternatif; $i++) {
            for ($j = 0; $j < $jumlahAlternatif; $j++) {
                if ($i === $j) continue;

                $setKriteria = [];
                $nilaiCij = 0;

                foreach ($bobotTernormalisasi[$i] as $namaKriteria => $nilaiI) {
                    $nilaiJ = $bobotTernormalisasi[$j][$namaKriteria];

                    if ($nilaiI >= $nilaiJ) {
                        $kriteriaItem = $kriteria->where('nama_kriteria', $namaKriteria)->first();
                        if ($kriteriaItem) {
                            $setKriteria[] = $kriteriaItem->id;
                            $nilaiCij += $kriteriaItem->bobot;
                        }
                    }
                }

                $concordanceSet["c" . ($i + 1) . "-" . ($j + 1)] = $setKriteria;
                $concordanceValue["c" . ($i + 1) . "-" . ($j + 1)] = round($nilaiCij, 3);
            }
        }

        $discordanceSet = [];
        $discordanceValue = [];

        for ($i = 0; $i < $jumlahAlternatif; $i++) {
            for ($j = 0; $j < $jumlahAlternatif; $j++) {
                if ($i === $j) continue;

                $setKriteria = [];
                $selisihSemua = [];
                $selisihDiskordan = [];

                foreach ($bobotTernormalisasi[$i] as $namaKriteria => $nilaiI) {
                    $nilaiJ = $bobotTernormalisasi[$j][$namaKriteria];
                    $selisih = abs($nilaiI - $nilaiJ);

                    // Simpan selisih untuk semua kriteria
                    $selisihSemua[] = $selisih;

                    // Cek apakah termasuk kriteria diskordan (nilaiI < nilaiJ)
                    if ($nilaiI < $nilaiJ) {
                        $kriteriaItem = $kriteria->where('nama_kriteria', $namaKriteria)->first();
                        if ($kriteriaItem) {
                            $setKriteria[] = $kriteriaItem->id;
                            $selisihDiskordan[] = $selisih;
                        }
                    }
                }

                // Hitung nilai Discordance
                $maxDiskordan = !empty($selisihDiskordan) ? max($selisihDiskordan) : 0;
                $maxSemua = !empty($selisihSemua) ? max($selisihSemua) : 1; // hindari div 0

                $nilaiDij = round($maxDiskordan / $maxSemua, 3);

                $discordanceSet["d" . ($i + 1) . "-" . ($j + 1)] = $setKriteria;
                $discordanceValue["d" . ($i + 1) . "-" . ($j + 1)] = $nilaiDij;
            }
        }

        return view('rekomendasi.hasil', [
            'data' => $data,
            'normalisasi' => $normalisasi,
            'bobotTernormalisasi' => $bobotTernormalisasi,
            'concordanceSet' => $concordanceSet,
            'concordanceValue' => $concordanceValue,
            'discordanceSet' => $discordanceSet,
            'discordanceValue' => $discordanceValue,
        ]);
    }
}
