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
                    'DT_RowIndex' => $index + 1,
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
}
