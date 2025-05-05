<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'nama_kriteria' => 'Siswa Penerima PIP',
                'kategori' => 'sekolah',
                'tipe' => 'angka',
                'satuan' => '%',
                'sifat' => 'benefit',
                'bobot' => 45,
            ],
            [
                'id' => 2,
                'nama_kriteria' => 'Akreditasi',
                'kategori' => 'sekolah',
                'tipe' => 'non-angka',
                'satuan' => 'A-E',
                'sifat' => 'cost',
                'bobot' => 15,
            ],
            [
                'id' => 3,
                'nama_kriteria' => 'Angka Stunting',
                'kategori' => 'wilayah',
                'tipe' => 'angka',
                'satuan' => '%',
                'sifat' => 'benefit',
                'bobot' => 15,
            ],
            [
                'id' => 4,
                'nama_kriteria' => 'Angka Kurang Gizi',
                'kategori' => 'wilayah',
                'tipe' => 'angka',
                'satuan' => '%',
                'sifat' => 'benefit',
                'bobot' => 10,
            ],
            [
                'id' => 5,
                'nama_kriteria' => 'Penerimaa Bantuan Sosial (PKH)',
                'kategori' => 'wilayah',
                'tipe' => 'angka',
                'satuan' => '%',
                'sifat' => 'benefit',
                'bobot' => 15,
            ]
        ];

        DB::table('kriteria')->insert($data);
    }
}
