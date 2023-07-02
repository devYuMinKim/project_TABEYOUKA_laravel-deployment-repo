<?php

namespace App\Recommendation\Actions;

use App\Services\RecruitApiService;
use App\Recommendation\Domain\UserGenrePreference;

class RecommendRestaurantsAction
{
  /**
   * 사용자 성향에 따른 인기 있는 가게 또는 랜덤 최상위 가게를 추천
   */
  public function __invoke(string $user_id, RecruitApiService $recruitApiService)
  {
    try {
      $preferred_genre = UserGenrePreference::getUserPreferredGenre($user_id);

      // 선호하는 장르를 기반으로 인기 있는 가게를 검색하거나 랜덤으로 인기 있는 가게를 검색
      $restaurants = $recruitApiService->getPopularRestaurantsByGenre($preferred_genre);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error occurred: ' . $e->getMessage()], 500);
    }

    return $restaurants;
  }
}
