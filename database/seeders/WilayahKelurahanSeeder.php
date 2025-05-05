<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WilayahKelurahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'nama_kelurahan' => 'Arjowinangun',
                'wilayah_kecamatan_id' => 1,
            ],
            [
                'id' => 2,
                'nama_kelurahan' => 'Bumiayu',
                'wilayah_kecamatan_id' => 1,
            ],
            [
                'id' => 3,
                'nama_kelurahan' => 'Buring',
                'wilayah_kecamatan_id' => 1,
            ],
            [
                'id' => 4,
                'nama_kelurahan' => 'Cemorokandang',
                'wilayah_kecamatan_id' => 1,
            ],
            [
                'id' => 5,
                'nama_kelurahan' => 'Kedungkandang',
                'wilayah_kecamatan_id' => 1,
            ],
            [
                'id' => 6,
                'nama_kelurahan' => 'Kota Lama',
                'wilayah_kecamatan_id' => 1,
            ],
            [
                'id' => 7,
                'nama_kelurahan' => 'Lesanpuro',
                'wilayah_kecamatan_id' => 1,
            ],
            [
                'id' => 8,
                'nama_kelurahan' => 'Madyopuro',
                'wilayah_kecamatan_id' => 1,
            ],
            [
                'id' => 9,
                'nama_kelurahan' => 'Mergosono',
                'wilayah_kecamatan_id' => 1,
            ],
            [
                'id' => 10,
                'nama_kelurahan' => 'Sawojajar',
                'wilayah_kecamatan_id' => 1,
            ],
            [
                'id' => 11,
                'nama_kelurahan' => 'Tlogowaru',
                'wilayah_kecamatan_id' => 1,
            ],
            [
                'id' => 12,
                'nama_kelurahan' => 'Wonokoyo',
                'wilayah_kecamatan_id' => 1,
            ]
        ];

        DB::table('wilayah_kelurahan')->insert($data);
    }
}
