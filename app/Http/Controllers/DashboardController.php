<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Sekolah;
use App\Models\WilayahKelurahan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSekolah = Sekolah::count();
        $totalWilayah = WilayahKelurahan::count();
        $kriteria = Kriteria::all();
        $dataTertinggi = [];

        foreach ($kriteria as $index => $item) {
            if ($item->tipe !== 'angka') {
                continue;
            }

            $topData = [];

            if ($item->kategori === 'wilayah') {
                $topWilayah = $item->nilaiKriteriaWilayah()
                    ->with('wilayahKelurahan')
                    ->orderByDesc('nilai')
                    ->take(10)
                    ->get();

                foreach ($topWilayah as $nilai) {
                    $topData[] = [
                        'nama' => $nilai->wilayahKelurahan->nama_kelurahan ?? '-',
                        'nilai' => $nilai->nilai
                    ];
                }
            } elseif ($item->kategori === 'sekolah') {
                $topSekolah = $item->nilaiKriteriaSekolah()
                    ->with('sekolah')
                    ->orderByDesc('nilai')
                    ->take(10)
                    ->get();

                foreach ($topSekolah as $nilai) {
                    $topData[] = [
                        'nama' => $nilai->sekolah->nama_sekolah ?? '-',
                        'nilai' => $nilai->nilai
                    ];
                }
            }

            $labelY = $item->satuan;
            if ($labelY == '%') {
                $labelY = 'Percent';
            }

            $dataTertinggi[] = [
                'kriteria' => $item->nama_kriteria,
                'labelY' => $labelY,
                'labelX' => $item->kategori === 'wilayah' ? 'wilayah (kelurahan)' : $item->kategori,
                'name' => 'chart' . $index + 1,
                'topData' => $topData,
            ];
        }

        return view('dashboard', [
            'title' => 'Dashboard',
            'totalSekolah' => $totalSekolah,
            'totalWilayah' => $totalWilayah,
            'kriteria' => $kriteria,
            'dataTertinggi' => $dataTertinggi,
        ]);
    }
}
