<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\NilaiKriteriaSekolah;
use App\Models\NilaiKriteriaWilayah;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class KriteriaController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $kriterias = Kriteria::all();

            return DataTables::of($kriterias)
                ->addIndexColumn()
                ->make(true);
        }

        return view('kriteria.index', [
            'title' => 'Data Kriteria'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'kategori' => 'required|in:wilayah,sekolah',
            'tipe' => 'required|in:angka,non-angka',
            'satuan' => 'required|string|max:50',
            'sifat' => 'required|in:benefit,cost',
            'bobot' => 'required|numeric|min:0|max:100'
        ]);

        Kriteria::create($request->all());
    }

    public function update(Request $request, Kriteria $kriteria)
    {
        $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'kategori' => 'required|in:wilayah,sekolah',
            'tipe' => 'required|in:angka,non-angka',
            'satuan' => 'required|string|max:50',
            'sifat' => 'required|in:benefit,cost',
            'bobot' => 'required|numeric|min:0|max:100'
        ]);

        $kriteria->update($request->all());
    }

    public function destroy(Kriteria $kriteria)
    {
        NilaiKriteriaWilayah::where('kriteria_id', $kriteria->id)->delete();
        NilaiKriteriaSekolah::where('kriteria_id', $kriteria->id)->delete();
        $kriteria->delete();
    }
}
