<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Teknoloji', 'slug' => 'teknoloji', 'description' => 'Yazılım, donanım ve teknoloji haberleri'],
            ['name' => 'Bilim', 'slug' => 'bilim', 'description' => 'Bilimsel gelişmeler ve keşifler'],
            ['name' => 'Matematik', 'slug' => 'matematik', 'description' => 'Matematik konuları ve problemler'],
            ['name' => 'Edebiyat', 'slug' => 'edebiyat', 'description' => 'Kitap incelemeleri ve yazılar'],
            ['name' => 'Sağlık', 'slug' => 'sağlik', 'description' => 'Sağlık ve yaşam tarzı'],
        ];

        foreach ($categories as $category) {
            Category::create(array_merge($category, ['status' => 'active']));
        }
    }
}
