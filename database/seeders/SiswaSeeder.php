<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Siswa',
            'email' => 'siswa@absensi.test',
            'password' => Hash::make('password'),
            'role' => 'siswa',
        ]);
    }
}