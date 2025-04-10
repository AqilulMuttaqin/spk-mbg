<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
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

    public function update(Request $request, $kriteria)
    {
        $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'kategori' => 'required|in:wilayah,sekolah',
            'tipe' => 'required|in:angka,non-angka',
            'satuan' => 'required|string|max:50',
            'sifat' => 'required|in:benefit,cost',
            'bobot' => 'required|numeric|min:0|max:100'
        ]);

        $kriteria = Kriteria::findOrFail($kriteria);
        $kriteria->update($request->all());
    }

    public function destroy($kriteria)
    {
        $kriteria = Kriteria::findOrFail($kriteria);
        $kriteria->delete();
    }
}
