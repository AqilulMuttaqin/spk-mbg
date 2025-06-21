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
        $sekolah = Sekolah::with(['wilayahKelurahan', 'wilayahKelurahan.wilayahKecamatan'])->get();
        $kriteria = Kriteria::all();
        $nilaiKriteriaSekolah = NilaiKriteriaSekolah::all();
        $nilaiKriteriaWilayah = NilaiKriteriaWilayah::all();

        // Step 1: Data Awal
        $dataAwal = $this->prepareInitialData($sekolah, $kriteria, $nilaiKriteriaSekolah, $nilaiKriteriaWilayah);

        // Cek Data Kosong
        if ($this->hasEmptyData($dataAwal)) {
            return view('rekomendasi.error', [
                'title' => 'Rekomendasi',
                'message' => 'Terdapat data kosong pada nilai kriteria. Silakan lengkapi data terlebih dahulu.',
            ]);
        }

        // Step 2: Matriks Keputusan
        $matriksKeputusan = $this->prepareDecisionMatrix($sekolah, $kriteria, $nilaiKriteriaSekolah, $nilaiKriteriaWilayah);

        // Step 3: Normalisasi Matriks Keputusan
        $normalisasi = $this->calculateNormalization($matriksKeputusan, $kriteria);

        // Step 4: Bobot Ternormalisasi
        $bobotTernormalisasi = $this->calculateWeightedNormalization($normalisasi, $kriteria);

        // Step 5: Concordance dan Discordance Values
        $concordanceResults = $this->calculateConcordance($bobotTernormalisasi, $kriteria);
        $discordanceResults = $this->calculateDiscordance($bobotTernormalisasi, $kriteria);

        // Step 6: Threshold dan Dominan Values
        $thresholdResults = $this->calculateThresholds(
            $concordanceResults['concordanceValue'],
            $discordanceResults['discordanceValue'],
            count($bobotTernormalisasi)
        );

        // Step 7: Agregat dan Ranking
        $rankingResults = $this->calculateRanking(
            $thresholdResults['concordanceDominanValue'],
            $thresholdResults['discordanceDominanValue'],
            $sekolah
        );

        if ($request->ajax()) {
            return $this->handleAjaxRequests($request, $dataAwal, $matriksKeputusan, $normalisasi, 
                $bobotTernormalisasi, $concordanceResults, $discordanceResults, $rankingResults);
        }

        return view('rekomendasi.index', [
            'title' => 'Rekomendasi',
            'kriteria' => $kriteria,
            'jumlahData' => count($sekolah),
            'concordanceValue' => $concordanceResults['concordanceValue'],
            'discordanceValue' => $discordanceResults['discordanceValue'],
            'totalConcordanceValue' => $thresholdResults['totalConcordanceValue'],
            'totalDiscordanceValue' => $thresholdResults['totalDiscordanceValue'],
            'cThreshold' => $thresholdResults['cThreshold'],
            'dThreshold' => $thresholdResults['dThreshold'],
            'concordanceDominanValue' => $thresholdResults['concordanceDominanValue'],
            'discordanceDominanValue' => $thresholdResults['discordanceDominanValue'],
            'agregatDominanValue' => $thresholdResults['agregatDominanValue'],
        ]);
    }

    private function prepareInitialData($sekolah, $kriteria, $nilaiKriteriaSekolah, $nilaiKriteriaWilayah)
    {
        return $sekolah->map(function ($sek, $index) use ($kriteria, $nilaiKriteriaSekolah, $nilaiKriteriaWilayah) {
            $wilayah = 'Kel. ' . $sek->wilayahKelurahan->nama_kelurahan . ', Kec. ' . $sek->wilayahKelurahan->wilayahKecamatan->nama_kecamatan;
            $row = [
                'alternatif' => 'A' . ($index + 1),
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

                $row[$k->nama_kriteria] = ($k->tipe == 'angka') 
                    ? ($nilai && $nilai->nilai !== null ? $nilai->nilai : '-')
                    : ($nilai && $nilai->nilai_non_angka !== null ? $nilai->nilai_non_angka : '-');
            }

            return $row;
        });
    }

    private function hasEmptyData($dataAwal)
    {
        return $dataAwal->contains(function ($item) {
            return in_array('-', $item);
        });
    }

    private function prepareDecisionMatrix($sekolah, $kriteria, $nilaiKriteriaSekolah, $nilaiKriteriaWilayah)
    {
        return $sekolah->map(function ($sek) use ($kriteria, $nilaiKriteriaSekolah, $nilaiKriteriaWilayah) {
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
    }

    private function calculateNormalization($matriksKeputusan, $kriteria)
    {
        $normalisasi = [];
    
        foreach ($kriteria as $k) {
            $namaKriteria = $k->nama_kriteria;
            $nilaiKriteria = $matriksKeputusan->pluck($namaKriteria)->map(function ($val) {
                return is_numeric($val) ? floatval($val) : 0;
            });
    
            $akarJumlahKuadrat = round(sqrt($nilaiKriteria->map(function ($v) {
                return $v * $v;
            })->sum()), 3);
    
            foreach ($matriksKeputusan as $i => $d) {
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
    
        return $normalisasi;
    }

    private function calculateWeightedNormalization($normalisasi, $kriteria)
    {
        $bobotTernormalisasi = [];
    
        foreach ($normalisasi as $i => $baris) {
            foreach ($baris as $namaKriteria => $nilaiNormalisasi) {
                $bobot = $kriteria->where('nama_kriteria', $namaKriteria)->first()?->bobot ?? 0;
                $bobotTernormalisasi[$i][$namaKriteria] = round($nilaiNormalisasi * $bobot, 3);
            }
        }
    
        return $bobotTernormalisasi;
    }

    private function calculateConcordance($bobotTernormalisasi, $kriteria)
    {
        $concordanceSet = [];
        $concordanceValue = [];
        $jumlahAlternatif = count($bobotTernormalisasi);
    
        for ($i = 0; $i < $jumlahAlternatif; $i++) {
            for ($j = 0; $j < $jumlahAlternatif; $j++) {
                if ($i === $j) continue;
    
                $setCKriteria = [];
                $nilaiCij = 0;
    
                foreach ($bobotTernormalisasi[$i] as $namaKriteria => $nilaiI) {
                    $nilaiJ = $bobotTernormalisasi[$j][$namaKriteria];
    
                    if ($nilaiI >= $nilaiJ) {
                        $kriteriaItem = $kriteria->where('nama_kriteria', $namaKriteria)->first();
                        if ($kriteriaItem) {
                            $setCKriteria[] = $kriteriaItem->id;
                            $nilaiCij += $kriteriaItem->bobot;
                        }
                    }
                }
    
                $concordanceSet["c" . ($i + 1) . "-" . ($j + 1)] = $setCKriteria;
                $concordanceValue["c" . ($i + 1) . "-" . ($j + 1)] = round($nilaiCij, 3);
            }
        }
    
        $consordanceIndex = [];
        foreach ($concordanceSet as $pasangan => $kriteriaSet) {
            $formattedSet = '{' . implode(',', $kriteriaSet) . '}';
            $consordanceIndex[] = [
                'pasangan' => $pasangan . ' = ' . $formattedSet,
                'nilai' => $concordanceValue[$pasangan],
            ];
        }
    
        return [
            'concordanceSet' => $concordanceSet,
            'concordanceValue' => $concordanceValue,
            'consordanceIndex' => $consordanceIndex,
        ];
    }

    private function calculateDiscordance($bobotTernormalisasi, $kriteria)
    {
        $discordanceSet = [];
        $discordanceValue = [];
        $jumlahAlternatif = count($bobotTernormalisasi);
    
        for ($i = 0; $i < $jumlahAlternatif; $i++) {
            for ($j = 0; $j < $jumlahAlternatif; $j++) {
                if ($i === $j) continue;
    
                $setDKriteria = [];
                $selisihSemua = [];
                $selisihDiskordan = [];
    
                foreach ($bobotTernormalisasi[$i] as $namaKriteria => $nilaiI) {
                    $nilaiJ = $bobotTernormalisasi[$j][$namaKriteria];
                    $selisih = abs($nilaiI - $nilaiJ);
                    $selisihSemua[] = $selisih;
    
                    if ($nilaiI < $nilaiJ) {
                        $kriteriaItem = $kriteria->where('nama_kriteria', $namaKriteria)->first();
                        if ($kriteriaItem) {
                            $setDKriteria[] = $kriteriaItem->id;
                            $selisihDiskordan[] = $selisih;
                        }
                    }
                }
    
                $maxDiskordan = !empty($selisihDiskordan) ? max($selisihDiskordan) : 0;
                $maxSemua = !empty($selisihSemua) ? max($selisihSemua) : 1;
                $nilaiDij = ($maxSemua > 0) ? round($maxDiskordan / $maxSemua, 3) : 0;
                
                $discordanceSet["d" . ($i + 1) . "-" . ($j + 1)] = $setDKriteria;
                $discordanceValue["d" . ($i + 1) . "-" . ($j + 1)] = $nilaiDij;
            }
        }
    
        $discordanceIndex = [];
        foreach ($discordanceSet as $pasangan => $kriteriaSet) {
            $formattedSet = '{' . implode(',', $kriteriaSet) . '}';
            $discordanceIndex[] = [
                'pasangan' => $pasangan . ' = ' . $formattedSet,
                'nilai' => $discordanceValue[$pasangan],
            ];
        }
    
        return [
            'discordanceSet' => $discordanceSet,
            'discordanceValue' => $discordanceValue,
            'discordanceIndex' => $discordanceIndex,
        ];
    }

    private function calculateThresholds($concordanceValue, $discordanceValue, $jumlahAlternatif)
    {
        $totalConcordanceValue = array_sum($concordanceValue);
        $cThreshold = round($totalConcordanceValue / ($jumlahAlternatif * ($jumlahAlternatif - 1)), 3);
        
        $concordanceDominanValue = [];
        foreach ($concordanceValue as $pasangan => $nilai) {
            $concordanceDominanValue[$pasangan] = $nilai >= $cThreshold ? 1 : 0;
        }
        
        $totalDiscordanceValue = array_sum($discordanceValue);
        $dThreshold = round($totalDiscordanceValue / ($jumlahAlternatif * ($jumlahAlternatif - 1)), 3);
    
        $discordanceDominanValue = [];
        foreach ($discordanceValue as $pasangan => $nilai) {
            $discordanceDominanValue[$pasangan] = $nilai <= $dThreshold ? 1 : 0;
        }
    
        $agregatDominanValue = [];
        foreach ($concordanceDominanValue as $cKey => $cValue) {
            $pasangan = substr($cKey, 1); 
            $dKey = 'd' . $pasangan;
            $dValue = $discordanceDominanValue[$dKey] ?? 0;
            $agregatDominanValue[$pasangan] = $cValue * $dValue;
        }
    
        return [
            'totalConcordanceValue' => $totalConcordanceValue,
            'totalDiscordanceValue' => $totalDiscordanceValue,
            'cThreshold' => $cThreshold,
            'dThreshold' => $dThreshold,
            'concordanceDominanValue' => $concordanceDominanValue,
            'discordanceDominanValue' => $discordanceDominanValue,
            'agregatDominanValue' => $agregatDominanValue,
        ];
    }

    private function calculateRanking($concordanceDominanValue, $discordanceDominanValue, $sekolah)
    {
        $agregatDominanValue = [];
        foreach ($concordanceDominanValue as $cKey => $cValue) {
            $pasangan = substr($cKey, 1); 
            $dKey = 'd' . $pasangan;
            $dValue = $discordanceDominanValue[$dKey] ?? 0;
            $agregatDominanValue[$pasangan] = $cValue * $dValue;
        }
    
        $totalAgregat = [];
        foreach ($agregatDominanValue as $pasangan => $nilai) {
            [$alt1, $alt2] = explode('-', $pasangan);
    
            if (!isset($totalAgregat[$alt1])) {
                $totalAgregat[$alt1] = 0;
            }
            $totalAgregat[$alt1] += $nilai;
        }
    
        $daftarAlternatif = $sekolah->map(function ($sek, $index) {
            return [
                'alternatif' => 'A' . ($index + 1),
                'sekolah' => $sek->nama_sekolah,
            ];
        })->toArray();
    
        $hasilRanking = [];
        foreach ($daftarAlternatif as $i => $alt) {
            $no = $i + 1;
            $total = $totalAgregat[$no] ?? 0;
            $hasilRanking[] = [
                'alternatif' => $alt['alternatif'],
                'sekolah' => $alt['sekolah'],
                'total_agregat' => $total,
            ];
        }
    
        usort($hasilRanking, function ($a, $b) {
            return $b['total_agregat'] <=> $a['total_agregat'];
        });
    
        foreach ($hasilRanking as $i => &$item) {
            $item['ranking'] = $i + 1;
        }
    
        return $hasilRanking;
    }

    private function handleAjaxRequests(
        $request,
        $dataAwal,
        $matriksKeputusan,
        $normalisasi,
        $bobotTernormalisasi,
        $concordanceResults,
        $discordanceResults,
        $rankingResults
    ) {
        if ($request->get('type') == 'dataAwal') {
            return DataTables::of($dataAwal)->make(true);
        }
        if ($request->get('type') == 'matriksKeputusan') {
            return DataTables::of($matriksKeputusan)
                ->addColumn('alternatif', function ($row) {
                    static $i = 1;
                    return 'A' . $i++;
                })
                ->make(true);
        }
        if ($request->get('type') == 'normalisasi') {
            return DataTables::of($normalisasi)
                ->addColumn('alternatif', function ($row) {
                    static $i = 1;
                    return 'A' . $i++;
                })
                ->make(true);
        }
        if ($request->get('type') == 'bobotTernormalisasi') {
            return DataTables::of($bobotTernormalisasi)
                ->addColumn('alternatif', function ($row) {
                    static $i = 1;
                    return 'A' . $i++;
                })
                ->make(true);
        }
        if ($request->get('type') == 'concordanceIndex') {
            return DataTables::of($concordanceResults['consordanceIndex'])->make(true);
        }
        if ($request->get('type') == 'discordanceIndex') {
            return DataTables::of($discordanceResults['discordanceIndex'])->make(true);
        }
        if ($request->get('type') == 'hasilRanking') {
            return DataTables::of($rankingResults)->make(true);
        }
    }
}