<?php

namespace App\Recommendation\Domain;

use Illuminate\Support\Facades\DB;

class UserGenrePreference
{
    public static function getUserPreferredGenre(string $user_id): ?string
    {
        $genres = [];
        $maxCount = -1;

        for ($i = 1; $i <= 17; $i++) {
            $genreColumn = 'G' . str_pad($i, 3, '0', STR_PAD_LEFT);
            $count = DB::table('user_genre_preferences')
                ->where('user_id', $user_id)
                ->value($genreColumn);

            if ($count > $maxCount) {
                $genres = [$genreColumn];
                $maxCount = $count;
            } elseif ($count == $maxCount) {
                $genres[] = $genreColumn;
            }
        }

        if ($maxCount == 0) {
            $randomIndex = rand(1, 17);
            $genreColumn = 'G' . str_pad($randomIndex, 3, '0', STR_PAD_LEFT);
            return $genreColumn;
        }

        return $genres[array_rand($genres)];
    }
}
