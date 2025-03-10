<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiKriteriaWilayah extends Model
{
    use HasFactory;

    protected $table = 'nilai_kriteria_wilayah';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'wilayah_kelurahan_id', 'kriteria_id', 'nilai_angka', 'nilai_non_angka'];

    public function wilayahKelurahan()
    {
        return $this->belongsTo(WilayahKelurahan::class, 'wilayah_kelurahan_id');
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }
}
