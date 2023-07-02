<?php

namespace App\Recommendation\Domain;

use Illuminate\Support\Facades\DB;

class UserGenrePreference
{
    /**
     * 사용자 성향에 따른 장르를 가져오는 메서드
     * - 최댓값이 동일한 자을가 있을 경우 랜덤 선택
     * - 모든 값이 0일 경우 랜덤 장르 선택
     */
    public static function getUserPreferredGenre(string $user_id): ?string
    {
        // 인자 검증
        if (empty($user_id)) {
            throw new \InvalidArgumentException('User ID cannot be empty');
        }
        
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

        // array_rand() 실패한 경우 처리 추가
        $genreIndex = array_rand($genres);
        if ($genreIndex === false) {
            throw new \RuntimeException('An error occurred while selecting a random genre');
        }

        return $genres[$genreIndex];
    }
}
