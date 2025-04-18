<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\NilaiKriteriaSekolah;
use App\Models\Sekolah;
use App\Models\WilayahKecamatan;
use App\Models\WilayahKelurahan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SekolahController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->get('type') == 'sekolah') {
                $sekolah = Sekolah::with(['wilayahKelurahan', 'wilayahKelurahan.wilayahKecamatan'])->get();
                return DataTables::of($sekolah)
                    ->addIndexColumn()
                    ->addColumn('kelurahan', function($row) {
                        return $row->wilayahKelurahan->nama_kelurahan;
                    })
                    ->addColumn('kecamatan', function ($row) {
                        return $row->wilayahKelurahan->wilayahKecamatan->nama_kecamatan ?? '-';
                    })
                    ->make(true);
            }
            if ($request->get('type') == 'kriteria_sekolah') {
                $sekolah = Sekolah::with(['wilayahKelurahan', 'wilayahKelurahan.wilayahKecamatan'])->get();
                $kriteriaSekolah = Kriteria::where('kategori', 'sekolah')->get();
                $nilaiKriteria = NilaiKriteriaSekolah::all();

                $data = $sekolah->map(function ($sek) use ($kriteriaSekolah, $nilaiKriteria) {
                    $wilayah = 'Kel. ' . $sek->wilayahKelurahan->nama_kelurahan . ', Kec. ' . $sek->wilayahKelurahan->wilayahKecamatan->nama_kecamatan;
                    $row = [
                        'DT_RowIndex' => $sek->id,
                        'sekolah' => $sek->nama_sekolah,
                        'wilayah' => $wilayah,
                    ];

                    foreach ($kriteriaSekolah as $kriteria) {
                        $nilai = $nilaiKriteria->where('sekolah_id', $sek->id)
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

                return DataTables::of($data)->make(true);
            }
        }
        return view('sekolah.index', [
            'title' => 'Data Sekolah',
            'kecamatan' => WilayahKecamatan::all(),
            'kriteriaSekolah' => Kriteria::where('kategori', 'sekolah')->get(),
        ]);
    }

    public function getKelurahan($wilayah_kecamatan_id)
    {
        $kelurahan = WilayahKelurahan::where('wilayah_kecamatan_id', $wilayah_kecamatan_id)->get();
        return response()->json($kelurahan);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'wilayah_kelurahan_id' => 'required|exists:wilayah_kelurahan,id',
        ]);

        Sekolah::create($request->all());
    }

    public function update(Request $request, Sekolah $sekolah)
    {
        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'wilayah_kelurahan_id' => 'required|exists:wilayah_kelurahan,id',
        ]);

        $sekolah->update($request->all());
    }

    public function destroy(Sekolah $sekolah)
    {
        $sekolah->delete();
    }
}
