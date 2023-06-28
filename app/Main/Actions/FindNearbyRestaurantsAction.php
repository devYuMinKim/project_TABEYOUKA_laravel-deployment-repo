<?php
// 주변 식당 확인 액션
namespace App\Main\Actions;

use App\Main\Domain\Restaurant;
use App\Services\RecruitApiService;
use App\Main\Responders\NearbyRestaurantsResponder;

class FindNearbyRestaurantsAction
{
  protected $recruitApiService;
  protected $responder;

  public function __construct(RecruitApiService $recruitApiService, NearbyRestaurantsResponder $responder)
  {
    $this->recruitApiService = $recruitApiService;
    $this->responder = $responder;
  }

  public function __invoke(float $latitude, float $longitude, float $range, ?string $keyword = null)
  {
    $restaurants = $this->recruitApiService->searchRestaurantsByUserLocation($latitude, $longitude, $range, $keyword);

    return $this->responder->respond($restaurants);
  }
}