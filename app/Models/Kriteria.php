<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $table = 'kriteria';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nama_kriteria', 'kategori', 'tipe', 'satuan', 'sifat', 'bobot'];

    public function nilaiKriteriaSekolah()
    {
        return $this->hasMany(NilaiKriteriaSekolah::class, 'kriteria_id');
    }

    public function nilaiKriteriaWilayah()
    {
        return $this->hasMany(NilaiKriteriaWilayah::class, 'kriteria_id');
    }
}
