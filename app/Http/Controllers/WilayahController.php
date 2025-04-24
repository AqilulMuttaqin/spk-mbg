<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\NilaiKriteriaWilayah;
use App\Models\WilayahKecamatan;
use App\Models\WilayahKelurahan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class WilayahController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->get('type') == 'kecamatan') {
                $wilayah = WilayahKecamatan::all();

                return DataTables::of($wilayah)
                    ->addColumn('index', function ($row) {
                        static $i = 1;
                        return $i++;
                    })
                    ->addColumn('action', function ($row) {
                        return view('wilayah.kecamatan.action-button', ['id' => $row->id])->render();
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            } 
            if ($request->get('type') == 'kelurahan') {
                $wilayah = WilayahKelurahan::with('wilayahKecamatan')->get();
    
                return DataTables::of($wilayah)
                    ->addColumn('index', function ($row) {
                        static $i = 1;
                        return $i++;
                    })
                    ->addColumn('kecamatan', function($row) {
                        return $row->wilayahKecamatan->nama_kecamatan;
                    })
                    ->addColumn('action', function ($row) {
                        return view('wilayah.kelurahan.action-button', ['id' => $row->id])->render();
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            if ($request->get('type') == 'kriteria_wilayah') {
                $kelurahan = WilayahKelurahan::with('wilayahKecamatan')->get();
                $kriteriaWilayah = Kriteria::where('kategori', 'wilayah')->get();
                $nilaiKriteria = NilaiKriteriaWilayah::all();

                $data = $kelurahan->map(function ($kel, $index) use ($kriteriaWilayah, $nilaiKriteria) {
                    $row = [
                        'id' => $kel->id,
                        'index' => $index + 1,
                        'kelurahan' => $kel->nama_kelurahan,
                        'kecamatan' => $kel->wilayahKecamatan->nama_kecamatan,
                    ];

                    foreach ($kriteriaWilayah as $kriteria) {
                        $nilai = $nilaiKriteria->where('wilayah_kelurahan_id', $kel->id)
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
                        return view('wilayah.nilai-kriteria-wilayah.action-button', ['id' => $row['id']])->render();
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
        }
        return view('wilayah.index', [
            'title' => 'Wilayah',
            'kriteriaWilayah' => Kriteria::where('kategori', 'wilayah')->get(),
            'kecamatan' => WilayahKecamatan::all(),
        ]);
    }

    public function storeKecamatan(Request $request)
    {
        try {
            $request->validate([
                'nama_kecamatan' => 'required|string|max:255|unique:wilayah_kecamatan,nama_kecamatan',
            ]);
    
            WilayahKecamatan::create($request->all());

            return response()->json([
                'message' => 'Data kecamatan berhasil disimpan.'
            ]);
        } catch (ValidationException $e) {
            $errors = $e->errors();
            if (isset($errors['nama_kecamatan'])) {
                return response()->json([
                    'status' => 'duplicate',
                    'message' => 'Nama kecamatan sudah ada.'
                ], 409);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal.'
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data kecamatan gagal disimpan.'
            ], 500);
        }
    }

    public function updateKecamatan(Request $request, WilayahKecamatan $kecamatan)
    {
        try {
            $request->validate([
                'nama_kecamatan' => 'required|string|max:255|unique:wilayah_kecamatan,nama_kecamatan,' . $kecamatan->id,
            ]);
    
            $kecamatan->update($request->all());

            return response()->json([
                'message' => 'Data kecamatan berhasil diperbarui.'
            ]);
        } catch (ValidationException $e) {
            $errors = $e->errors();
            if (isset($errors['nama_kecamatan'])) {
                return response()->json([
                    'status' => 'duplicate',
                    'message' => 'Nama kecamatan sudah ada.'
                ], 409);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal.'
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data kecamatan gagal diperbarui.'
            ], 500);
        }
    }

    public function destroyKecamatan(WilayahKecamatan $kecamatan)
    {
        try {
            $kecamatan->delete();

            return response()->json([
                'message' => 'Data kecamatan berhasil dihapus.'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data kecamatan gagal dihapus.'
            ], 500);
        }
    }

    public function storeKelurahan(Request $request)
    {
        try {
            $request->validate([
                'nama_kelurahan' => 'required|string|max:255|unique:wilayah_kelurahan,nama_kelurahan,NULL,id,wilayah_kecamatan_id,' . $request->input('wilayah_kecamatan_id'),
                'wilayah_kecamatan_id' => 'required|exists:wilayah_kecamatan,id',
            ]);
            
            WilayahKelurahan::create($request->all());

            return response()->json([
                'message' => 'Data kelurahan berhasil disimpan.'
            ]);
        } catch (ValidationException $e) {
            $errors = $e->errors();
            if (isset($errors['nama_kelurahan'])) {
                return response()->json([
                    'status' => 'duplicate',
                    'message' => 'Nama kelurahan sudah ada.'
                ], 409);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal.'
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data kelurahan gagal disimpan.'
            ], 500);
        }
    }

    public function updateKelurahan(Request $request, WilayahKelurahan $kelurahan)
    {
        try {
            $request->validate([
                'nama_kelurahan' => 'required|string|max:255|unique:wilayah_kelurahan,nama_kelurahan,' . $kelurahan->id . ',id,wilayah_kecamatan_id,' . $request->input('wilayah_kecamatan_id'),
                'wilayah_kecamatan_id' => 'required|exists:wilayah_kecamatan,id',
            ]);
    
            $kelurahan->update($request->all());

            return response()->json([
                'message' => 'Data kelurahan berhasil diperbarui.'
            ]);
        } catch (ValidationException $e) {
            $errors = $e->errors();
            if (isset($errors['nama_kelurahan'])) {
                return response()->json([
                    'status' => 'duplicate',
                    'message' => 'Nama kelurahan sudah ada.'
                ], 409);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal.'
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data kelurahan gagal diperbarui.'
            ], 500);
        }
    }

    public function destroyKelurahan(WilayahKelurahan $kelurahan)
    {
        try {
            $kelurahan->delete();

            return response()->json([
                'message' => 'Data kelurahan berhasil dihapus.'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data kelurahan gagal dihapus.'
            ], 500);
        }
    }

    public function updateNilaiKriteria(Request $request)
    {
        try {
            $namaKelurahan = $request->input('nama_kelurahan');
            $wilayahKelurahanId = WilayahKelurahan::where('nama_kelurahan', $namaKelurahan)->first()->id;
    
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
    
                    NilaiKriteriaWilayah::updateOrCreate(
                        [
                            'wilayah_kelurahan_id' => $wilayahKelurahanId,
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
                'message' => 'Data gagal diperbarui.'
            ], 500);
        }
    }
}
