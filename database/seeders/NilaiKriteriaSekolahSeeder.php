<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NilaiKriteriaSekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['SDN ARJOWINANGUN 1', 47.13, 5],
            ['SDN ARJOWINANGUN 2', 3.61, 5],
            ['SDN BUMIAYU 1', 3.83, 4],
            ['SDN BUMIAYU 2', 15.95, 4],
            ['SDN BUMIAYU 3', 27.5, 5],
            ['SDN BUMIAYU 4', 5.59, 4],
            ['SDN BURING', 16.09, 4],
            ['SDN CEMOROKANDANG 1', 19.05, 4],
            ['SDN CEMOROKANDANG 2', 37.5, 5],
            ['SDN CEMOROKANDANG 3', 63.86, 4],
            ['SDN CEMOROKANDANG 4', 98.83, 4],
            ['SDN KEDUNGKANDANG 1', 56.47, 5],
            ['SDN KEDUNGKANDANG 2', 10.78, 4],
            ['SDN KOTALAMA 1', 37.39, 5],
            ['SDN KOTALAMA 2', 22.32, 5],
            ['SDN KOTALAMA 3', 22.73, 5],
            ['SDN KOTALAMA 4', 27.44, 4],
            ['SDN KOTALAMA 5', 18.27, 4],
            ['SDN KOTALAMA 6', 28.66, 4],
            ['SDN LESANPURO 1', 26.06, 4],
            ['SDN LESANPURO 2', 31.46, 4],
            ['SDN LESANPURO 3', 23.65, 4],
            ['SDN LESANPURO 4', 8.18, 5],
            ['SDN MADYOPURO 1', 11.11, 5],
            ['SDN MADYOPURO 2', 12.82, 4],
            ['SDN MADYOPURO 3', 33.47, 5],
            ['SDN MADYOPURO 4', 23.1, 4],
            ['SDN MADYOPURO 5', 28.66, 5],
            ['SDN MADYOPURO 6', 55.41, 4],
            ['SDN MERGOSONO 1', 23.26, 4],
            ['SDN MERGOSONO 2', 41.1, 5],
            ['SDN MERGOSONO 3', 54.38, 4],
            ['SDN MERGOSONO 4', 56.34, 4],
            ['SDN MERGOSONO 5', 56.39, 4],
            ['SDN MODEL', 2.34, 5],
            ['SDN SAWOJAJAR 1', 11.53, 5],
            ['SDN SAWOJAJAR 2', 26.79, 4],
            ['SDN SAWOJAJAR 3', 18.56, 5],
            ['SDN SAWOJAJAR 4', 29.38, 5],
            ['SDN SAWOJAJAR 5', 4.14, 5],
            ['SDN SAWOJAJAR 6', 15.77, 5],
            ['SDN TLOGOWARU 1', 13.1, 4],
            ['SDN TLOGOWARU 2', 26.06, 4],
            ['SDN WONOKOYO 1', 28.07, 4],
            ['SDN WONOKOYO 2', 61.9, 3],
        ];

        $konversiNonAngka = [
            5 => 'A',
            4 => 'B',
            3 => 'C',
            2 => 'D',
            1 => 'E',
        ];

        foreach ($data as $index => [$nama, $nilai1, $nilai2]) {
            $sekolahId = $index + 1;

            DB::table('nilai_kriteria_sekolah')->insert([
                [
                    'sekolah_id' => $sekolahId,
                    'kriteria_id' => 1,
                    'nilai' => $nilai1,
                    'nilai_non_angka' => null,
                ],
                [
                    'sekolah_id' => $sekolahId,
                    'kriteria_id' => 2,
                    'nilai' => $nilai2,
                    'nilai_non_angka' => $konversiNonAngka[$nilai2] ?? null,
                ],
            ]);
        }
    }
}
