<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\NilaiKriteriaSekolah;
use App\Models\NilaiKriteriaWilayah;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ElectreIElectreIIController extends Controller
{
    public function electreI(Request $request)
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
            return $this->handleAjaxRequestsElectreI(
                $request,
                $dataAwal,
                $matriksKeputusan,
                $normalisasi,
                $bobotTernormalisasi,
                $concordanceResults,
                $discordanceResults
            );
        }

        return view('rekomendasi.electre-i', [
            'title' => 'Perhitungan Electre I',
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
            'sekolahTerbaik' => $rankingResults,
        ]);
    }

    public function electreII(Request $request)
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

        // Step 6: Perangkingan
        $rankingResults = $this->calculateElectreIIRanking(
            $concordanceResults['concordanceValue'],
            $discordanceResults['discordanceValue'],
            $sekolah
        );

        if ($request->ajax()) {
            return $this->handleAjaxRequestsElectreII(
                $request,
                $dataAwal,
                $matriksKeputusan,
                $normalisasi,
                $bobotTernormalisasi,
                $concordanceResults,
                $discordanceResults,
                $rankingResults
            );
        }

        return view('rekomendasi.electre-ii', [
            'title' => 'Perhitungan Electre II',
            'kriteria' => $kriteria,
            'jumlahData' => count($sekolah),
            'concordanceValue' => $concordanceResults['concordanceValue'],
            'discordanceValue' => $discordanceResults['discordanceValue'],
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

        $totalBobot = $kriteria->sum('bobot');

        $normalizedWeights = [];
        if ($totalBobot != 100) {
            foreach ($kriteria as $k) {
                $normalizedWeights[$k->nama_kriteria] = ($k->bobot / $totalBobot) * 100;
            }
        } else {
            foreach ($kriteria as $k) {
                $normalizedWeights[$k->nama_kriteria] = $k->bobot;
            }
        }

        foreach ($normalisasi as $i => $baris) {
            foreach ($baris as $namaKriteria => $nilaiNormalisasi) {
                $bobot = $normalizedWeights[$namaKriteria] ?? 0;
                $bobotTernormalisasi[$i][$namaKriteria] = round($nilaiNormalisasi * ($bobot / 100), 3);
            }
        }

        return $bobotTernormalisasi;
    }

    private function calculateConcordance($bobotTernormalisasi, $kriteria)
    {
        $concordanceSet = [];
        $concordanceValue = [];
        $jumlahAlternatif = count($bobotTernormalisasi);

        $totalBobot = $kriteria->sum('bobot');

        foreach ($kriteria as $k) {
            $k->normalized_bobot = ($totalBobot != 100) ? ($k->bobot / $totalBobot) * 100 : $k->bobot;
        }

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
                            $nilaiCij += ($kriteriaItem->normalized_bobot / 100);
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

        $kriteria = Kriteria::orderBy('bobot', 'desc')->first();
        $nilaiKriteriaSekolah = NilaiKriteriaSekolah::all();
        $nilaiKriteriaWilayah = NilaiKriteriaWilayah::all();

        $hasilRanking = [];
        foreach ($sekolah as $i => $sek) {
            $altNo = $i + 1;
            $nilaiTieBreaker = 0;

            if ($kriteria) {
                if ($kriteria->kategori == 'sekolah') {
                    $nilai = $nilaiKriteriaSekolah->where('sekolah_id', $sek->id)
                        ->where('kriteria_id', $kriteria->id)
                        ->first();
                } else {
                    $nilai = $nilaiKriteriaWilayah->where('wilayah_kelurahan_id', $sek->wilayah_kelurahan_id)
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

            $hasilRanking[] = [
                'alternatif' => 'A' . $altNo,
                'sekolah' => $sek->nama_sekolah,
                'wilayah' => 'Kel. ' . $sek->wilayahKelurahan->nama_kelurahan . ', Kec. ' . $sek->wilayahKelurahan->wilayahKecamatan->nama_kecamatan,
                'total_agregat' => $totalAgregat[$altNo] ?? 0,
                'tie_breaker_value' => $nilaiTieBreaker,
            ];
        }

        // Urutkan descending by total agregat, lalu tie breaker
        usort($hasilRanking, function ($a, $b) {
            $cmp = $b['total_agregat'] <=> $a['total_agregat'];
            return $cmp === 0 ? $b['tie_breaker_value'] <=> $a['tie_breaker_value'] : $cmp;
        });

        // Ambil hanya yang terbaik
        $terbaik = $hasilRanking[0] ?? null;

        if ($terbaik) {
            $terbaik['ranking'] = 1;
            unset($terbaik['tie_breaker_value']);
        }


        return $terbaik;
    }


    private function calculateElectreIIRanking($concordanceValue, $discordanceValue, $sekolah)
    {
        $jumlahAlternatif = count($sekolah);

        $concordanceMurni = [];
        $discordanceMurni = [];

        for ($i = 1; $i <= $jumlahAlternatif; $i++) {
            $outgoingC = 0;
            $incomingC = 0;
            $outgoingD = 0;
            $incomingD = 0;

            for ($j = 1; $j <= $jumlahAlternatif; $j++) {
                if ($i == $j) continue;

                $keyOut = "c{$i}-{$j}";
                $keyIn = "c{$j}-{$i}";

                $outgoingC += $concordanceValue[$keyOut] ?? 0;
                $incomingC += $concordanceValue[$keyIn] ?? 0;

                $keyOutD = "d{$i}-{$j}";
                $keyInD = "d{$j}-{$i}";

                $outgoingD += $discordanceValue[$keyOutD] ?? 0;
                $incomingD += $discordanceValue[$keyInD] ?? 0;
            }

            $concordanceMurni[$i] = round($outgoingC - $incomingC, 3);
            $discordanceMurni[$i] = round($outgoingD - $incomingD, 3);
        }

        // Ambil info alternatif
        $daftarAlternatif = $sekolah->map(function ($sek, $index) {
            return [
                'no' => $index + 1,
                'alternatif' => 'A' . ($index + 1),
                'sekolah' => $sek->nama_sekolah,
                'sekolah_id' => $sek->id,
                'wilayah_kelurahan_id' => $sek->wilayah_kelurahan_id,
            ];
        })->toArray();

        // Ambil tie breaker
        $kriteriaUtama = Kriteria::orderBy('bobot', 'desc')->first();
        $nilaiKriteriaSekolah = NilaiKriteriaSekolah::all();
        $nilaiKriteriaWilayah = NilaiKriteriaWilayah::all();

        $hasil = [];
        foreach ($daftarAlternatif as $alt) {
            $tieBreaker = 0;

            if ($kriteriaUtama) {
                if ($kriteriaUtama->kategori === 'sekolah') {
                    $nilai = $nilaiKriteriaSekolah
                        ->where('sekolah_id', $alt['sekolah_id'])
                        ->where('kriteria_id', $kriteriaUtama->id)
                        ->first();
                } else {
                    $nilai = $nilaiKriteriaWilayah
                        ->where('wilayah_kelurahan_id', $alt['wilayah_kelurahan_id'])
                        ->where('kriteria_id', $kriteriaUtama->id)
                        ->first();
                }

                if ($nilai && $nilai->nilai !== null) {
                    $tieBreaker = floatval($nilai->nilai);
                    if ($kriteriaUtama->sifat === 'cost') {
                        $tieBreaker *= -1;
                    }
                }
            }

            $no = $alt['no'];

            $hasil[] = [
                'alternatif' => $alt['alternatif'],
                'sekolah' => $alt['sekolah'],
                'c_murni' => $concordanceMurni[$no],
                'd_murni' => $discordanceMurni[$no],
                'tie_breaker' => $tieBreaker,
            ];
        }

        // Rank Concordance (semakin tinggi semakin baik)
        usort($hasil, function ($a, $b) {
            $cmp = $b['c_murni'] <=> $a['c_murni'];
            return $cmp === 0 ? $b['tie_breaker'] <=> $a['tie_breaker'] : $cmp;
        });
        foreach ($hasil as $i => &$row) {
            $row['rank_c'] = $i + 1;
        }

        // Rank Discordance (semakin kecil semakin baik)
        usort($hasil, function ($a, $b) {
            $cmp = $a['d_murni'] <=> $b['d_murni'];
            return $cmp === 0 ? $b['tie_breaker'] <=> $a['tie_breaker'] : $cmp;
        });
        foreach ($hasil as $i => &$row) {
            $row['rank_d'] = $i + 1;
        }

        // Avg rank + final ranking
        foreach ($hasil as &$row) {
            $row['avg_rank'] = round(($row['rank_c'] + $row['rank_d']) / 2, 2);
        }

        usort($hasil, function ($a, $b) {
            $cmp = $a['avg_rank'] <=> $b['avg_rank'];
            return $cmp === 0 ? $b['tie_breaker'] <=> $a['tie_breaker'] : $cmp;
        });

        foreach ($hasil as $i => &$row) {
            $row['final_rank'] = $i + 1;
            unset($row['tie_breaker']);
        }

        return $hasil;
    }


    private function handleAjaxRequestsElectreI(
        $request,
        $dataAwal,
        $matriksKeputusan,
        $normalisasi,
        $bobotTernormalisasi,
        $concordanceResults,
        $discordanceResults
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
    }

    private function handleAjaxRequestsElectreII(
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
