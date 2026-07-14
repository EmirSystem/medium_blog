<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'role_id' => 1,
            'name' => 'Admin Kullanıcı',
            'email' => 'admin@system.com',
            'password' => Hash::make('password1234'),
            'bio' => 'Sistem Yöneticisi',
            'status' => 'active',
        ]);

        User::create([
            'role_id' => 2,
            'name' => 'Ahmet Yazar',
            'email' => 'ahmet@system.com',
            'password' => Hash::make('password123'),
            'bio' => 'Teknoloji Yazarı',
            'status' => 'active',
        ]);

        User::create([
            'role_id' => 2,
            'name' => 'Ayşe Yazar',
            'email' => 'ayşe@system.com',
            'password' => Hash::make('password123'),
            'bio' => 'Bilim Yazarı',
            'status' => 'active',
        ]);
    }
}
