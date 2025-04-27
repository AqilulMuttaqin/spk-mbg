<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\NilaiKriteriaSekolah;
use App\Models\Sekolah;
use App\Models\WilayahKecamatan;
use App\Models\WilayahKelurahan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class SekolahController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->get('type') == 'sekolah') {
                $sekolah = Sekolah::with(['wilayahKelurahan', 'wilayahKelurahan.wilayahKecamatan'])->get();
                return DataTables::of($sekolah)
                    ->addColumn('index', function ($row) {
                        static $i = 1;
                        return $i++;
                    })
                    ->addColumn('kelurahan', function($row) {
                        return $row->wilayahKelurahan->nama_kelurahan;
                    })
                    ->addColumn('kecamatan', function ($row) {
                        return $row->wilayahKelurahan->wilayahKecamatan->nama_kecamatan ?? '-';
                    })
                    ->addColumn('action', function ($row) {
                        return view('sekolah.action-button', ['id' => $row->id])->render();
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            if ($request->get('type') == 'kriteria_sekolah') {
                $sekolah = Sekolah::with(['wilayahKelurahan', 'wilayahKelurahan.wilayahKecamatan'])->get();
                $kriteriaSekolah = Kriteria::where('kategori', 'sekolah')->get();
                $nilaiKriteria = NilaiKriteriaSekolah::all();

                $data = $sekolah->map(function ($sek, $index) use ($kriteriaSekolah, $nilaiKriteria) {
                    $wilayah = 'Kel. ' . $sek->wilayahKelurahan->nama_kelurahan . ', Kec. ' . $sek->wilayahKelurahan->wilayahKecamatan->nama_kecamatan;
                    $row = [
                        'id' => $sek->id,
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

                return DataTables::of($data)
                    ->addColumn('index', function ($row) {
                        static $i = 1;
                        return $i++;
                    })
                    ->addColumn('action', function ($row) {
                        return view('sekolah.nilai-kriteria-sekolah.action-button', ['id' => $row['id']])->render();
                    })
                    ->rawColumns(['action'])
                    ->make(true);
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
        try {
            $request->validate([
                'nama_sekolah' => 'required|string|max:255|unique:sekolah,nama_sekolah,NULL,id,wilayah_kelurahan_id,'.$request->input('wilayah_kelurahan_id'),
                'wilayah_kelurahan_id' => 'required|exists:wilayah_kelurahan,id',
            ]);
    
            Sekolah::create($request->all());
            
            return response()->json([
                'message' => 'Data sekolah berhasil disimpan.'
            ]);
        } catch (ValidationException $e) {
            $errors = $e->errors();
            if (isset($errors['nama_sekolah'])) {
                return response()->json([
                    'status' => 'duplicate',
                    'message' => 'Nama sekolah sudah ada.'
                ], 409);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal.'
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data sekolah gagal disimpan.'
            ], 500);
        }
    }

    public function show(Sekolah $sekolah)
    {
        $kelurahan = WilayahKelurahan::where('wilayah_kecamatan_id', $sekolah->wilayahKelurahan->wilayahKecamatan->id)->get();
        
        return response()->json([
            'sekolah' => $sekolah,
            'kelurahan' => $kelurahan,
        ]);
    }

    public function update(Request $request, Sekolah $sekolah)
    {
        try {
            $request->validate([
                'nama_sekolah' => 'required|string|max:255|unique:sekolah,nama_sekolah,'.$sekolah->id.',id,wilayah_kelurahan_id,'.$request->input('wilayah_kelurahan_id'),
                'wilayah_kelurahan_id' => 'required|exists:wilayah_kelurahan,id',
            ]);
    
            $sekolah->update($request->all());

            return response()->json([
                'message' => 'Data sekolah berhasil diperbarui.'
            ]);
        } catch (ValidationException $e) {
            $errors = $e->errors();
            if (isset($errors['nama_sekolah'])) {
                return response()->json([
                    'status' => 'duplicate',
                    'message' => 'Nama sekolah sudah ada.'
                ], 409);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal.'
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data sekolah gagal diperbarui.'
            ], 500);
        }
    }

    public function destroy(Sekolah $sekolah)
    {
        try {
            $sekolah->delete();

            return response()->json([
                'message' => 'Data sekolah berhasil dihapus.'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data sekolah gagal dihapus.'
            ], 500);
        }
    }

    public function updateNilaiKriteria(Request $request)
    {
        try { 
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

            return response()->json([
                'message' => 'Data nilai berhasil diperbarui.'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data nilai gagal diperbarui.'
            ], 500);
        }
    }
}
