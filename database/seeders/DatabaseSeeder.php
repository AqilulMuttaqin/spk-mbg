<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // DB::table('users')->insert([
        //     [
        //         'name' => 'Admin User',
        //         'username' => 'admin',
        //         'email' => 'admin@example.com',
        //         'email_verified_at' => now(),
        //         'password' => Hash::make('password123'),
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]
        // ]);

        $this->call([
            UsersSeeder::class,
            KriteriaSeeder::class,
            WilayahKecamatanSeeder::class,
            WilayahKelurahanSeeder::class,
            SekolahSeeder::class,
            // NilaiKriteriaWilayahSeeder::class,
            // NilaiKriteriaSekolahSeeder::class,
        ]);
    }
}
