<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\NilaiKriteriaWilayah;
use App\Models\WilayahKecamatan;
use App\Models\WilayahKelurahan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class WilayahController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->get('type') == 'kecamatan') {
                $wilayah = WilayahKecamatan::all();
                return DataTables::of($wilayah)
                    ->addIndexColumn()
                    ->make(true);
            } 
            if ($request->get('type') == 'kelurahan') {
                $wilayah = WilayahKelurahan::with('wilayahKecamatan')->get();
    
                return DataTables::of($wilayah)
                    ->addIndexColumn()
                    ->addColumn('kecamatan', function($row) {
                        return $row->wilayahKecamatan->nama_kecamatan;
                    })
                    ->make(true);
            }
            if ($request->get('type') == 'kriteria_wilayah') {
                $kelurahan = WilayahKelurahan::with('wilayahKecamatan')->get();
                $kriteriaWilayah = Kriteria::where('kategori', 'Wilayah')->get();
                $nilaiKriteria = NilaiKriteriaWilayah::all();

                $data = $kelurahan->map(function ($kel) use ($kriteriaWilayah, $nilaiKriteria) {
                    $row = [
                        'DT_RowIndex' => $kel->id, // Pastikan ini sesuai dengan kebutuhan
                        'kelurahan' => $kel->nama_kelurahan,
                        'kecamatan' => $kel->wilayahKecamatan->nama_kecamatan,
                    ];

                    foreach ($kriteriaWilayah as $kriteria) {
                        $nilai = $nilaiKriteria->where('wilayah_kelurahan_id', $kel->id)
                                    ->where('kriteria_id', $kriteria->id)
                                    ->first();
                        
                        if ($kriteria->tipe == 'angka') {
                            $row[$kriteria->nama_kriteria] = $nilai ? $nilai->nilai : '-';
                        } else {
                            $row[$kriteria->nama_kriteria] = $nilai ? $nilai->nilai_non_angka : '-';
                        }
                    }

                    return $row;
                });

                return DataTables::of($data)->addIndexColumn()->make(true);
            }
        }
        return view('wilayah.index', [
            'title' => 'Wilayah',
            'kriteriaWilayah' => Kriteria::where('kategori', 'wilayah')->get(),
        ]);
    }

    public function storeKecamatan(Request $request)
    {
        $request->validate([
            'nama_kecamatan' => 'required|string|max:255',
        ]);

        WilayahKecamatan::create($request->all());
    }

    public function updateKecamatan(Request $request, $kecamatan)
    {
        $request->validate([
            'nama_kecamatan' => 'required|string|max:255',
        ]);

        $kecamatan = WilayahKecamatan::findOrFail($kecamatan);
        $kecamatan->update($request->all());
    }

    public function destroyKecamatan($kecamatan)
    {
        $kecamatan = WilayahKecamatan::findOrFail($kecamatan);
        $kecamatan->delete();
    }
}
