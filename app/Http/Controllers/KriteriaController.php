<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\NilaiKriteriaSekolah;
use App\Models\NilaiKriteriaWilayah;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class KriteriaController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $kriterias = Kriteria::all();

            return DataTables::of($kriterias)
                ->addColumn('index', function ($row) {
                    static $i = 1;
                    return $i++;
                })
                ->addColumn('action', function ($row) {
                    return view('kriteria.action-button', ['id' => $row->id])->render();
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('kriteria.index', [
            'title' => 'Data Kriteria'
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_kriteria' => 'required|string|max:255|unique:kriteria,nama_kriteria,NULL,id,kategori,'.$request->input('kategori'),
                'kategori' => 'required|in:wilayah,sekolah',
                'tipe' => 'required|in:angka,non-angka',
                'satuan' => 'required|string|max:50',
                'sifat' => 'required|in:benefit,cost',
                'bobot' => 'required|numeric|min:0|max:100'
            ]);
    
            Kriteria::create($request->all());
    
            return response()->json([
                'message' => 'Data kriteria berhasil disimpan.'
            ]);
        } catch (ValidationException $e) {
            $errors = $e->errors();
            if (isset($errors['nama_kriteria'])) {
                return response()->json([
                    'status' => 'duplicate',
                    'message' => 'Nama kriteria sudah ada.'
                ], 409);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal.'
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data kriteria gagal disimpan.'
            ], 500);
        }
    }

    public function update(Request $request, Kriteria $kriteria)
    {
        try {
            $request->validate([
                'nama_kriteria' => 'required|string|max:255|unique:kriteria,nama_kriteria,'.$kriteria->id.',id,kategori,'.$request->input('kategori'),
                'kategori' => 'required|in:wilayah,sekolah',
                'tipe' => 'required|in:angka,non-angka',
                'satuan' => 'required|string|max:50',
                'sifat' => 'required|in:benefit,cost',
                'bobot' => 'required|numeric|min:0|max:100'
            ]);
    
            $kriteria->update($request->all());

            return response()->json([
                'message' => 'Data kriteria berhasil diperbarui.'
            ]);
        } catch (ValidationException $e) {
            $errors = $e->errors();
            if (isset($errors['nama_kriteria'])) {
                return response()->json([
                    'status' => 'duplicate',
                    'message' => 'Nama kriteria sudah ada.'
                ], 409);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal.'
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data kriteria gagal diperbarui.'
            ], 500);
        }
    }

    public function destroy(Kriteria $kriteria)
    {
        try {
            NilaiKriteriaWilayah::where('kriteria_id', $kriteria->id)->delete();
            NilaiKriteriaSekolah::where('kriteria_id', $kriteria->id)->delete();

            $kriteria->delete();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Data kriteria berhasil dihapus.'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data kriteria gagal dihapus.'
            ], 500);
        }
    }
}
