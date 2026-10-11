<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nama' => 'Admin IT',
            'username' => 'admin',
            'departemen' => 'IT',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'nama' => 'Andi',
            'username' => 'andi',
            'departemen' => 'Produksi',
            'password' => Hash::make('123456'),
            'role' => 'user',
        ]);
    }
}