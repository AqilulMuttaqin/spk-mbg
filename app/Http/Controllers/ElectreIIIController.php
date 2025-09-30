<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\NilaiKriteriaSekolah;
use App\Models\NilaiKriteriaWilayah;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ElectreIIIController extends Controller
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
        
        // Step 3: Bobot dan Threshold
        $weightsAndThresholds = $this->calculateWeightsAndThresholds($kriteria, $matriksKeputusan);

        // Step 4: Concordance Index
        $concordanceIndex = $this->calculateConcordanceIndex($sekolah, $matriksKeputusan, $weightsAndThresholds);
        
        // Step 5: Discordance Index
        $discordanceIndex = $this->calculateDiscordanceIndex($sekolah, $matriksKeputusan, $weightsAndThresholds);
        
        // Step 6: Credibility Index
        $credibilityIndex = $this->calculateCredibilityIndex($concordanceIndex, $discordanceIndex, $weightsAndThresholds);
        
        // Step 7: Hasil Akhir
        $rankingResults = $this->calculateElectreIIIRanking(
            $credibilityIndex,
            $sekolah,
            $nilaiKriteriaSekolah,
            $nilaiKriteriaWilayah
        );

        if ($request->ajax()) {
            return $this->handleAjaxRequest(
                $request,
                $dataAwal,
                $matriksKeputusan,
                $weightsAndThresholds,
                $concordanceIndex,
                $discordanceIndex,
                $rankingResults
            );
        }

        return view('rekomendasi.electre-iii', [
            'title' => 'Perhitungan Electre III',
            'jumlahData' => count($sekolah),
            'kriteria' => $kriteria,
            'credibilityIndex' => $credibilityIndex,
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

    private function calculateWeightsAndThresholds($kriteria, $matriksKeputusan)
    {
        $totalBobot = $kriteria->sum('bobot');

        $result = $kriteria->map(function ($k) use ($totalBobot, $matriksKeputusan) {
            $bobotNormalized = $k->bobot / $totalBobot;

            $q = 0;
            $p = 0;
            $v = null;

            if ($k->tipe == 'angka') {
                $values = $matriksKeputusan->pluck($k->nama_kriteria)->filter(function ($value) {
                    return $value !== '-';
                })->toArray();

                if (count($values) > 0) {
                    $min = min($values);
                    $max = max($values);
                    $range = $max - $min;

                    $q = round($range * 0.1, 2);
                    $p = round($range * 0.5, 2);
                    $v = round($range * 0.75, 2);
                }
            }

            return [
                'nama_kriteria' => $k->nama_kriteria,
                'bobot' => $bobotNormalized,
                'q' => $q,
                'p' => $p,
                'v' => $v,
                'tipe' => $k->tipe,
                'kategori' => $k->sifat
            ];
        });

        return $result;
    }

    private function calculateConcordanceIndex($sekolah, $matriksKeputusan, $weightsAndThresholds)
    {
        $alternatives = $sekolah->pluck('nama_sekolah')->toArray();
        $kriteriaNames = $weightsAndThresholds->pluck('nama_kriteria')->toArray();

        $concordanceMatrix = [];

        foreach ($alternatives as $i => $alt1) {
            foreach ($alternatives as $j => $alt2) {
                if ($i == $j) continue;

                $pairKey = 'A' . ($i + 1) . '-A' . ($j + 1);
                $concordanceMatrix[$pairKey] = [];

                foreach ($kriteriaNames as $kriteriaName) {
                    $kriteriaData = $weightsAndThresholds->firstWhere('nama_kriteria', $kriteriaName);

                    $nilaiAlt1 = $matriksKeputusan[$i][$kriteriaName];
                    $nilaiAlt2 = $matriksKeputusan[$j][$kriteriaName];

                    if ($nilaiAlt1 === '-' || $nilaiAlt2 === '-') {
                        $concordanceMatrix[$pairKey][$kriteriaName] = null;
                        continue;
                    }

                    $q = $kriteriaData['q'];
                    $p = $kriteriaData['p'];
                    $isCost = $kriteriaData['kategori'] == 'cost';

                    if ($isCost) {
                        $nilaiAlt1 = -$nilaiAlt1;
                        $nilaiAlt2 = -$nilaiAlt2;
                    }

                    if ($kriteriaData['tipe'] !== 'angka') {
                        $concordanceMatrix[$pairKey][$kriteriaName] = ($nilaiAlt1 >= $nilaiAlt2) ? 1 : 0;
                        continue;
                    }

                    if ($nilaiAlt1 + $q >= $nilaiAlt2) {
                        $c = 1;
                    } elseif ($nilaiAlt1 + $p <= $nilaiAlt2) {
                        $c = 0;
                    } else {
                        $c = ($nilaiAlt1 + $p - $nilaiAlt2) / ($p - $q);
                        $c = round($c, 2);
                    }

                    $concordanceMatrix[$pairKey][$kriteriaName] = $c;
                }
            }
        }

        return $concordanceMatrix;
    }

    private function calculateDiscordanceIndex($sekolah, $matriksKeputusan, $weightsAndThresholds)
    {
        $alternatives = $sekolah->pluck('nama_sekolah')->toArray();
        $kriteriaNames = $weightsAndThresholds->pluck('nama_kriteria')->toArray();

        $discordanceMatrix = [];

        foreach ($alternatives as $i => $alt1) {
            foreach ($alternatives as $j => $alt2) {
                if ($i == $j) continue;

                $pairKey = 'A' . ($i + 1) . '-A' . ($j + 1);
                $discordanceMatrix[$pairKey] = [];

                foreach ($kriteriaNames as $kriteriaName) {
                    $kriteriaData = $weightsAndThresholds->firstWhere('nama_kriteria', $kriteriaName);

                    $nilaiAlt1 = $matriksKeputusan[$i][$kriteriaName];
                    $nilaiAlt2 = $matriksKeputusan[$j][$kriteriaName];

                    if ($nilaiAlt1 === '-' || $nilaiAlt2 === '-') {
                        $discordanceMatrix[$pairKey][$kriteriaName] = null;
                        continue;
                    }

                    $p = $kriteriaData['p'];
                    $v = $kriteriaData['v'];
                    $isCost = $kriteriaData['kategori'] == 'cost';

                    if ($isCost) {
                        $nilaiAlt1 = -$nilaiAlt1; 
                        $nilaiAlt2 = -$nilaiAlt2; 
                    }

                    if ($kriteriaData['tipe'] !== 'angka') {
                        $discordanceMatrix[$pairKey][$kriteriaName] = 0;
                        continue;
                    }

                    if ($nilaiAlt1 + $p >= $nilaiAlt2) {
                        $d = 0;
                    } else if ($nilaiAlt1 + $v <= $nilaiAlt2) {
                        $d = 1;
                    } else {
                        $d = ($nilaiAlt2 - $nilaiAlt1 - $p) / ($v - $p);
                        $d = round($d, 2);
                    }

                    $discordanceMatrix[$pairKey][$kriteriaName] = $d;
                }
            }
        }

        return $discordanceMatrix;
    }

    private function calculateCredibilityIndex($concordanceIndex, $discordanceIndex, $weightsAndThresholds)
    {
        $credibilityMatrix = [];
        $kriteriaNames = $weightsAndThresholds->pluck('nama_kriteria')->toArray();
        
        foreach ($concordanceIndex as $pairKey => $concordanceValues) {
            $totalConcordance = 0;
            
            foreach ($kriteriaNames as $kriteriaName) {
                $kriteriaData = $weightsAndThresholds->firstWhere('nama_kriteria', $kriteriaName);
                $concordanceValue = $concordanceValues[$kriteriaName] ?? 0;
                $totalConcordance += $kriteriaData['bobot'] * $concordanceValue;
            }
            
            $totalConcordance = round($totalConcordance, 2);
            
            if ($totalConcordance === '-') {
                $credibilityMatrix[$pairKey] = '-';
                continue;
            }

            $productTerms = 1;
            foreach ($kriteriaNames as $kriteriaName) {
                $discordanceValue = $discordanceIndex[$pairKey][$kriteriaName] ?? 0;
                $concordanceValue = $concordanceIndex[$pairKey][$kriteriaName] ?? 0;
                
                if ($discordanceValue > $totalConcordance) {
                    $term = (1 - $discordanceValue) / (1 - $concordanceValue);
                    $productTerms *= $term;
                }
            }
            
            $credibility = $totalConcordance * $productTerms;
            $credibilityMatrix[$pairKey] = round($credibility, 4);
        }
        
        return $credibilityMatrix;
    }

    private function calculateElectreIIIRanking($credibilityIndex, $sekolah, $nilaiKriteriaSekolah, $nilaiKriteriaWilayah)
    {
        $jumlahAlternatif = count($sekolah);

        $distilasiDescending =[];
        for ($i = 1; $i <= $jumlahAlternatif; $i++) {
            $total = 0;
            for ($j = 1; $j <= $jumlahAlternatif; $j++) {
                if ($i != $j) {
                    $pairKey = 'A' . ($i) . '-A' . ($j);
                    $total += ($credibilityIndex[$pairKey] >= 0.70) ? 1 : 0;
                }
            }
            $distilasiDescending[$i] = $total;
        }
        
        $distilasiAscending = [];
        for ($i = 1; $i <= $jumlahAlternatif; $i++) {
            $total = 0;
            for ($j = 1; $j <= $jumlahAlternatif; $j++) {
                if ($i != $j) {
                    $pairKey = 'A' . ($j) . '-A' . ($i);
                    $total += ($credibilityIndex[$pairKey] >= 0.70) ? 1 : 0;
                }
            }
            $distilasiAscending[$i] = $total;
        }

        $daftarAlternatif = $sekolah->map(function ($sek, $index) {
            return [
                'alternatif' => 'A' . ($index + 1),
                'sekolah' => $sek->nama_sekolah,
                'sekolah_id' => $sek->id,
                'wilayah_kelurahan_id' => $sek->wilayah_kelurahan_id,
            ];
        })->toArray();

        $kriteria = Kriteria::orderBy('bobot', 'desc')->first();

        $dataRanking = [];
        foreach ($daftarAlternatif as $i => $alt) {
            $no = $i + 1;

            $nilaiTieBreaker = 0;
            if ($kriteria) {
                if ($kriteria->kategori == 'sekolah') {
                    $nilai = $nilaiKriteriaSekolah->where('sekolah_id', $alt['sekolah_id'])
                        ->where('kriteria_id', $kriteria->id)
                        ->first();
                } else {
                    $nilai = $nilaiKriteriaWilayah->where('wilayah_kelurahan_id', $alt['wilayah_kelurahan_id'])
                        ->where('kriteria_id', $kriteria->id)
                        ->first();
                }

                if ($nilai && $nilai->nilai !== null) {
                    $nilaiTieBreaker = floatval($nilai->nilai);

                    if ($kriteria->sifat == 'cost') {
                        $nilaiTieBreaker = -$nilaiTieBreaker;
                    }
                }
            }

            $dataRanking[] = [
                'alternatif' => $alt['alternatif'],
                'sekolah' => $alt['sekolah'],
                'distilasi_descending' => $distilasiDescending[$no],
                'distilasi_ascending' => $distilasiAscending[$no],
                'tie_breaker_value' => $nilaiTieBreaker,
            ];
        }

        $dataForDescRank = $dataRanking;
        usort($dataForDescRank, function ($a, $b) {
            $comparison = $b['distilasi_descending'] <=> $a['distilasi_descending'];
            if ($comparison === 0) {
                return $b['tie_breaker_value'] <=> $a['tie_breaker_value'];
            }
            return $comparison;
        });

        $rankDesc = [];
        foreach ($dataForDescRank as $i => $item) {
            $rankDesc[$item['alternatif']] = $i + 1;
        }

        $dataForAscRank = $dataRanking;
        usort($dataForAscRank, function ($a, $b) {
            $comparison = $a['distilasi_ascending'] <=> $b['distilasi_ascending'];
            if ($comparison === 0) {
                return $b['tie_breaker_value'] <=> $a['tie_breaker_value'];
            }
            return $comparison;
        });

        $rankAsc = [];
        foreach ($dataForAscRank as $i => $item) {
            $rankAsc[$item['alternatif']] = $i + 1;
        }

        $hasilFinal = [];
        foreach ($dataRanking as $item) {
            $alt = $item['alternatif'];
            $avgRank = ($rankDesc[$alt] + $rankAsc[$alt]) / 2;

            $hasilFinal[] = [
                'alternatif' => $alt,
                'sekolah' => $item['sekolah'],
                'distilasi_descending' => $item['distilasi_descending'],
                'rank_desc' => $rankDesc[$alt],
                'distilasi_ascending' => $item['distilasi_ascending'],
                'rank_asc' => $rankAsc[$alt],
                'avg_rank' => round($avgRank, 2),
                'tie_breaker_value' => $item['tie_breaker_value'],
            ];
        }

         usort($hasilFinal, function ($a, $b) {
            $comparison = $a['avg_rank'] <=> $b['avg_rank'];
            if ($comparison === 0) {
                return $b['tie_breaker_value'] <=> $a['tie_breaker_value'];
            }
            return $comparison;
        });

        foreach ($hasilFinal as $i => &$item) {
            $item['final_rank'] = $i + 1;
            unset($item['tie_breaker_value']);
        }

        return $hasilFinal;
    }

    private function handleAjaxRequest(
        $request,
        $dataAwal,
        $matriksKeputusan,
        $weightsAndThresholds,
        $concordanceIndex,
        $discordanceIndex,
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
        if ($request->get('type') == 'bobotThreshold') {
            return DataTables::of($weightsAndThresholds)->make(true);
        }
        if ($request->get('type') == 'concordanceIndex') {
            $data = [];
            foreach ($concordanceIndex as $pairKey => $values) {
                $row = ['perbandingan' => $pairKey];
                foreach ($values as $kriteria => $nilai) {
                    $row[$kriteria] = $nilai;
                }
                $data[] = $row;
            }
            return DataTables::of($data)->make(true);
        }
        if ($request->get('type') == 'discordanceIndex') {
            $data = [];
            foreach ($discordanceIndex as $pairKey => $values) {
                $row = ['perbandingan' => $pairKey];
                foreach ($values as $kriteria => $nilai) {
                    $row[$kriteria] = $nilai;
                }
                $data[] = $row;
            }
            return DataTables::of($data)->make(true);
        }
        if ($request->get('type') == 'hasilRanking') {
            return DataTables::of($rankingResults)->make(true);
        }
    }
}
