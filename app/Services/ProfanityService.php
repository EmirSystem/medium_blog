<?php

namespace App\Services;

use App\Models\BannedWord;

class ProfanityService
{
    /**
     * Verilen metni aktif yasaklı kelimeler ile karşılaştırır.
     * Küfür/sakıncalı kelime bulunursa true döner.
     */
    public function check(string $text): bool
    {
        $words = BannedWord::where('status', 'active')->pluck('word');
        $lowerText = mb_strtolower($text);

        foreach ($words as $word) {
            if (str_contains($lowerText, mb_strtolower($word))) {
                return true;
            }
        }

        return false;
    }
}
