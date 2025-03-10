<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WilayahKelurahan extends Model
{
    use HasFactory;

    protected $table = 'wilayah_kelurahan';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'wilayah_kecamatan_id', 'nama_kelurahan'];
    
    public function wilayahKecamatan()
    {
        return $this->belongsTo(WilayahKecamatan::class, 'wilayah_kecamatan_id');
    }

    public function sekolah()
    {
        return $this->hasMany(Sekolah::class, 'wilayah_kelurahan_id');
    }

    public function nilaiKriteriaWilayah()
    {
        return $this->hasMany(NilaiKriteriaWilayah::class, 'wilayah_kelurahan_id');
    }
}
