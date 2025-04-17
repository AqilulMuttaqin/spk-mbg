<?php

namespace App\Http\Controllers;

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
        }
        return view('sekolah.index', [
            'title' => 'Data Sekolah',
            'kelurahan' => WilayahKelurahan::all(),
            'kecamatan' => WilayahKecamatan::all(),
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
