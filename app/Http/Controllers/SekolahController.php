<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\NilaiKriteriaSekolah;
use App\Models\Sekolah;
use App\Models\WilayahKecamatan;
use App\Models\WilayahKelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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

                $data = $sekolah->map(function ($sek, $index) use ($kriteriaSekolah, $nilaiKriteria) {
                    $wilayah = 'Kel. ' . $sek->wilayahKelurahan->nama_kelurahan . ', Kec. ' . $sek->wilayahKelurahan->wilayahKecamatan->nama_kecamatan;
                    $row = [
                        'DT_RowIndex' => $index + 1,
                        'sekolah' => $sek->nama_sekolah,
                        'wilayah' => $wilayah,
                    ];

                    foreach ($kriteriaSekolah as $kriteria) {
                        $nilai = $nilaiKriteria->where('sekolah_id', $sek->id)
                                    ->where('kriteria_id', $kriteria->id)
                                    ->first();
                        
                        if ($kriteria->tipe == 'angka') {
                            $row[$kriteria->nama_kriteria] = ($nilai && $nilai->nilai !== null) ? $nilai->nilai : '-';
                        } else {
                            $row[$kriteria->nama_kriteria] = ($nilai && $nilai->nilai_non_angka !== null) ? $nilai->nilai_non_angka : '-';
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

    public function updateNilaiKriteria(Request $request)
    {
        $namaSekolah = $request->input('nama_sekolah');
        $sekolahId = Sekolah::where('nama_sekolah', $namaSekolah)->first()->id;

        $konversiHurufKeAngka = [
            'A' => 5,
            'B' => 4,
            'C' => 3,
            'D' => 2,
            'E' => 1,
        ];

        foreach ($request->all() as $key => $value) {
            if (Str::startsWith($key, 'kriteria-')) {
                $kriteriaId = (int) Str::after($key, 'kriteria-');

                $kriteria = Kriteria::find($kriteriaId);

                $nilai = null;
                $nilaiNonAngka = null;

                if ($kriteria && $kriteria->tipe === 'angka') {
                    $nilai = $value !== null && $value !== '' ? $value : null;
                } else {
                    $nilaiNonAngka = $value !== null && $value !== '' ? $value : null;;
                    $nilai = isset($konversiHurufKeAngka[$value]) ? $konversiHurufKeAngka[$value] : null;
                }
                
                NilaiKriteriaSekolah::updateOrCreate(
                    [
                        'sekolah_id' => $sekolahId,
                        'kriteria_id' => $kriteriaId,
                    ],
                    [
                        'nilai' => $nilai,
                        'nilai_non_angka' => $nilaiNonAngka,
                    ]
                );
            }
        }
    }
}
