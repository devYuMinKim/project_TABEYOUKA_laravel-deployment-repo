<?php

namespace App\Search\Actions;

use App\Search\Domain\Repositories\RestaurantRepository;
use App\Services\RecruitApiService;
use App\Search\Responders\FindNearbyRestaurantsResponder;

/**
 * 주변 식당 확인 액션 클래스
 * - 사용자 위치 기반 가게 검색 기능을 수행
 */
class FindNearbyRestaurantsAction
{
  protected $recruitApiService;
  protected $responder;

  public function __construct(RecruitApiService $recruitApiService, FindNearbyRestaurantsResponder $responder)
  {
    $this->recruitApiService = $recruitApiService;
    $this->responder = $responder;
  }

  public function __invoke(float $latitude, float $longitude, float $range, ?string $keyword = null)
  {
    try {
      $restaurants = $this->recruitApiService->searchRestaurantsByUserLocation($latitude, $longitude, $range, $keyword);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error occurred: ' . $e->getMessage()], 500);
    }
    
    return $this->responder->__invoke($restaurants);
  }
}