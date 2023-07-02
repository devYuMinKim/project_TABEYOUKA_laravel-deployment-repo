<?php

namespace App\Recommendation\Domain\Repositories;

use App\Recommendation\Domain\Entities\UserGenrePreference;
use Illuminate\Support\Facades\DB;

/**
 * 사용자 장르 선호도 저장소 클래스
 */
class UserGenrePreferenceRepository
{
    /**
     * 사용자 ID로 사용자 선호 장르 조회
     */
    public function findByUserId(string $userId): ?UserGenrePreference
    {
        $genrePreferences = DB::table('user_genre_preferences')->where('user_id', $userId)->first();

        if (!$genrePreferences) {
            return null;
        }

        $preferences = collect($genrePreferences)->except('user_id')->toArray();

        return new UserGenrePreference($userId, $preferences);
    }
}
