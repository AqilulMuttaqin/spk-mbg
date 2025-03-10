<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiKriteriaSekolah extends Model
{
    use HasFactory;

    protected $table = 'nilai_kriteria_sekolah';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'sekolah_id', 'kriteria_id', 'nilai_angka', 'nilai_non_angka'];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id');
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }
}
