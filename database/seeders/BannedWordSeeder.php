<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BannedWord;

class BannedWordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $words = [
            'küfür1',
            'küfür2',
            'küfür3',
            'salak',
            'aptal',
            'gerizekali',
            'mal',
            'manyak',
            'deli',
        ];

        foreach ($words as $word) {
            BannedWord::create([
                'word' => $word,
                'status' => 'active',
            ]);
        }
    }
}
