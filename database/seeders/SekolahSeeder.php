<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id' => 1, 'nama_sekolah' => 'SDN Arjowinangun 1', 'wilayah_kelurahan_id' => 1],
            ['id' => 2, 'nama_sekolah' => 'SDN Arjowinangun 2', 'wilayah_kelurahan_id' => 1],
            ['id' => 3, 'nama_sekolah' => 'SDN Bumiayu 1', 'wilayah_kelurahan_id' => 2],
            ['id' => 4, 'nama_sekolah' => 'SDN Bumiayu 2', 'wilayah_kelurahan_id' => 2],
            ['id' => 5, 'nama_sekolah' => 'SDN Bumiayu 3', 'wilayah_kelurahan_id' => 2],
            ['id' => 6, 'nama_sekolah' => 'SDN Bumiayu 4', 'wilayah_kelurahan_id' => 2],
            ['id' => 7, 'nama_sekolah' => 'SDN Buring', 'wilayah_kelurahan_id' => 3],
            ['id' => 8, 'nama_sekolah' => 'SDN Cemorokandang 1', 'wilayah_kelurahan_id' => 4],
            ['id' => 9, 'nama_sekolah' => 'SDN Cemorokandang 2', 'wilayah_kelurahan_id' => 4],
            ['id' => 10, 'nama_sekolah' => 'SDN Cemorokandang 3', 'wilayah_kelurahan_id' => 4],
            ['id' => 11, 'nama_sekolah' => 'SDN Cemorokandang 4', 'wilayah_kelurahan_id' => 4],
            ['id' => 12, 'nama_sekolah' => 'SDN Kedungkandang 1', 'wilayah_kelurahan_id' => 5],
            ['id' => 13, 'nama_sekolah' => 'SDN Kedungkandang 2', 'wilayah_kelurahan_id' => 5],
            ['id' => 14, 'nama_sekolah' => 'SDN Kotalama 1', 'wilayah_kelurahan_id' => 6],
            ['id' => 15, 'nama_sekolah' => 'SDN Kotalama 2', 'wilayah_kelurahan_id' => 6],
            ['id' => 16, 'nama_sekolah' => 'SDN Kotalama 3', 'wilayah_kelurahan_id' => 6],
            ['id' => 17, 'nama_sekolah' => 'SDN Kotalama 4', 'wilayah_kelurahan_id' => 6],
            ['id' => 18, 'nama_sekolah' => 'SDN Kotalama 5', 'wilayah_kelurahan_id' => 6],
            ['id' => 19, 'nama_sekolah' => 'SDN Kotalama 6', 'wilayah_kelurahan_id' => 6],
            ['id' => 20, 'nama_sekolah' => 'SDN Lesanpuro 1', 'wilayah_kelurahan_id' => 7],
            ['id' => 21, 'nama_sekolah' => 'SDN Lesanpuro 2', 'wilayah_kelurahan_id' => 7],
            ['id' => 22, 'nama_sekolah' => 'SDN Lesanpuro 3', 'wilayah_kelurahan_id' => 7],
            ['id' => 23, 'nama_sekolah' => 'SDN Lesanpuro 4', 'wilayah_kelurahan_id' => 7],
            ['id' => 24, 'nama_sekolah' => 'SDN Madyopuro 1', 'wilayah_kelurahan_id' => 8],
            ['id' => 25, 'nama_sekolah' => 'SDN Madyopuro 2', 'wilayah_kelurahan_id' => 8],
            ['id' => 26, 'nama_sekolah' => 'SDN Madyopuro 3', 'wilayah_kelurahan_id' => 8],
            ['id' => 27, 'nama_sekolah' => 'SDN Madyopuro 4', 'wilayah_kelurahan_id' => 8],
            ['id' => 28, 'nama_sekolah' => 'SDN Madyopuro 5', 'wilayah_kelurahan_id' => 8],
            ['id' => 29, 'nama_sekolah' => 'SDN Madyopuro 6', 'wilayah_kelurahan_id' => 8],
            ['id' => 30, 'nama_sekolah' => 'SDN Mergosono 1', 'wilayah_kelurahan_id' => 9],
            ['id' => 31, 'nama_sekolah' => 'SDN Mergosono 2', 'wilayah_kelurahan_id' => 9],
            ['id' => 32, 'nama_sekolah' => 'SDN Mergosono 3', 'wilayah_kelurahan_id' => 9],
            ['id' => 33, 'nama_sekolah' => 'SDN Mergosono 4', 'wilayah_kelurahan_id' => 9],
            ['id' => 34, 'nama_sekolah' => 'SDN Mergosono 5', 'wilayah_kelurahan_id' => 9],
            ['id' => 35, 'nama_sekolah' => 'SD Model', 'wilayah_kelurahan_id' => 11],
            ['id' => 36, 'nama_sekolah' => 'SDN Sawojajar 1', 'wilayah_kelurahan_id' => 10],
            ['id' => 37, 'nama_sekolah' => 'SDN Sawojajar 2', 'wilayah_kelurahan_id' => 10],
            ['id' => 38, 'nama_sekolah' => 'SDN Sawojajar 3', 'wilayah_kelurahan_id' => 10],
            ['id' => 39, 'nama_sekolah' => 'SDN Sawojajar 4', 'wilayah_kelurahan_id' => 10],
            ['id' => 40, 'nama_sekolah' => 'SDN Sawojajar 5', 'wilayah_kelurahan_id' => 10],
            ['id' => 41, 'nama_sekolah' => 'SDN Sawojajar 6', 'wilayah_kelurahan_id' => 10],
            ['id' => 42, 'nama_sekolah' => 'SDN Tlogowaru 1', 'wilayah_kelurahan_id' => 11],
            ['id' => 43, 'nama_sekolah' => 'SDN Tlogowaru 2', 'wilayah_kelurahan_id' => 11],
            ['id' => 44, 'nama_sekolah' => 'SDN Wonokoyo 1', 'wilayah_kelurahan_id' => 12],
            ['id' => 45, 'nama_sekolah' => 'SDN Wonokoyo 2', 'wilayah_kelurahan_id' => 12],
        ];

        DB::table('sekolah')->insert($data);
    }
}
