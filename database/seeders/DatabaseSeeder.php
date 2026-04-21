<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // akun admin
        User::create([
            'name'     => 'Administrator Utama',
            'username' => 'admin',
            'password' => bcrypt('password'),
            'role'     => 'admin',
        ]);

        // akun guru
        User::create([
            'name'     => 'Guru Pengajar',
            'username' => 'guru',
            'password' => bcrypt('password'),
            'role'     => 'guru',
        ]);

        // akun siswa
        User::create([
            'name'     => 'Siswa Percobaan',
            'username' => 'siswa', 
            'password' => bcrypt('password'),
            'role'     => 'siswa',
        ]);
    }
}
