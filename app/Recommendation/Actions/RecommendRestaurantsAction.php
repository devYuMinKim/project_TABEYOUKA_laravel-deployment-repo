<?php

namespace App\Recommendation\Actions;

use App\Services\RecruitApiService;
use App\Recommendation\Domain\Repositories\UserGenrePreferenceRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Exception;

/**
 * 사용자 성향에 따른 가게 추천 액션 클래스
 */
class RecommendRestaurantsAction
{
    protected $userGenrePreferenceRepository;
    protected $recruitApiService;

    /**
     * RecommendRestaurantsAction 인스턴스 생성
     *
     * @param  UserGenrePreferenceRepository  $userGenrePreferenceRepository
     * @param  RecruitApiService  $recruitApiService
     */
    public function __construct(UserGenrePreferenceRepository $userGenrePreferenceRepository, RecruitApiService $recruitApiService)
    {
        $this->userGenrePreferenceRepository = $userGenrePreferenceRepository;
        $this->recruitApiService = $recruitApiService;
    }

    /**
     * 사용자 성향에 따른 인기 있는 가게 또는 랜덤 최상위 가게를 추천
     * Recommend popular restaurants or random top-rated restaurants based on user preferences.
     *
     * @param  string  $user_id
     * @return JsonResponse
     */
    public function __invoke(string $user_id): JsonResponse
    {
        $restaurants = [];

        try {
            $userGenrePreference = $this->userGenrePreferenceRepository->findByUserId($user_id);

            if ($userGenrePreference !== null) {
                $preferred_genre = $userGenrePreference->getPreferences();
                $restaurants = $this->recruitApiService->getPopularRestaurantsByGenre($preferred_genre);
            } else {
                // 사용자 성향이 없을 경우 랜덤 최상위 가게를 추천
                $restaurants = $this->recruitApiService->getPopularRestaurantsByGenre();
            }

        } catch (Exception $e) {
            Log::error('Error occurred in RecommendRestaurantsAction: ' . $e->getMessage());
            return response()->json(['error' => 'Error occurred: ' . $e->getMessage()], 500);
        }

        return response()->json($restaurants);
    }
}
