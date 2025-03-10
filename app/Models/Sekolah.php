<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;

    protected $table = 'sekolah';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nama_sekolah', 'wilayah_kelurahan_id'];

    public function wilayahKelurahan()
    {
        return $this->belongsTo(WilayahKelurahan::class, 'wilayah_kelurahan_id');
    }

    public function nilaiKriteriaSekolah()
    {
        return $this->hasMany(NilaiKriteriaSekolah::class, 'sekolah_id');
    }
}
