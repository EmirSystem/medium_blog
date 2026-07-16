<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'Süper Admin',
            'slug' => 'super-admin',
            'description' => 'Sistemin tam yetkili yöneticisi',
            'status' => 'active',
        ]);

        Role::create([
            'name' => 'Yazar',
            'slug' => 'yazar',
            'description' => 'Blog Yazısı yazabilen standart kullanıcı',
            'status' => 'active',
        ]);
    }
}
