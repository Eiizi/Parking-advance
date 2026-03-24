<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // delete old user function
        User::truncate();

        // 1. Admin account
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@elmer.com',
            'password' => Hash::make('password123'),
            'role' => 'admin' // role
        ]);

        // 2. Account worker
        User::create([
            'name' => 'Petugas Pintu Utara',
            'email' => 'pegawai@elmer.com',
            'password' => Hash::make('password123'),
            'role' => 'pegawai' // role.
        ]);
    }
}