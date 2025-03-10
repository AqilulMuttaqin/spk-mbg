<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WilayahKecamatan extends Model
{
    use HasFactory;

    protected $table = 'wilayah_kecamatan';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nama_kecamatan'];
    
    public function wilayahKelurahan()
    {
        return $this->hasMany(WilayahKelurahan::class, 'wilayah_kelurahan_id');
    }
}
