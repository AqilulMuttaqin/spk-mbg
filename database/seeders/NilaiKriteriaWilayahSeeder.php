<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NilaiKriteriaWilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['Arjowinangun', 2.51, 11.35, 4.82],
            ['Bumiayu', 3.78, 15.92, 8.8],
            ['Buring', 4.06, 8.19, 1.19],
            ['Cemorokandang', 3.31, 4.29, 6.44],
            ['Kedungkandang', 6.93, 3.55, 8.39],
            ['Kotalama', 4.92, 6.12, 4.9],
            ['Lesanpuro', 4.24, 3.02, 5.03],
            ['Madyopuro', 1.88, 3.38, 2.56],
            ['Mergosono', 6.22, 10.05, 8.11],
            ['Sawojajar', 1.27, 1.4, 3.76],
            ['Tlogowaru', 8.54, 13.29, 9.36],
            ['Wonokoyo', 4.56, 4.59, 4.87],
        ];

        foreach ($data as $index => [$nama, $nilai1, $nilai2, $nilai3]) {
            $kelurahanId = $index + 1;

            DB::table('nilai_kriteria_wilayah')->insert([
                [
                    'wilayah_kelurahan_id' => $kelurahanId,
                    'kriteria_id' => 3,
                    'nilai' => $nilai1,
                    'nilai_non_angka' => null,
                ],
                [
                    'wilayah_kelurahan_id' => $kelurahanId,
                    'kriteria_id' => 4,
                    'nilai' => $nilai2,
                    'nilai_non_angka' => null,
                ],
                [
                    'wilayah_kelurahan_id' => $kelurahanId,
                    'kriteria_id' => 5,
                    'nilai' => $nilai3,
                    'nilai_non_angka' => null,
                ],
            ]);
        }
    }
}
