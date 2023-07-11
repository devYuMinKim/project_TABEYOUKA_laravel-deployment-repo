<?php

namespace App\Search\Actions;

use App\Services\RecruitApiService;
use App\Search\Responders\SearchRestaurantsResponder;

/**
 * 메인 페이지에서의 검색 액션 클래스
 * - 가게 검색 요청을 처리하고 결과를 반환함
 */
class SearchRestaurantsAction
{
  protected $recruitApiService;
  protected $responder;

  public function __construct(RecruitApiService $recruitApiService, SearchRestaurantsResponder $responder)
  {
    $this->recruitApiService = $recruitApiService;
    $this->responder = $responder;
  }

  public function __invoke(?string $genre = null, ?string $area = null, ?float $lat = null, ?float $lng = null, ?string $keyword = null) {
    try {
      $results = $this->recruitApiService->searchRestaurantsByLocationCode($genre, $area, $lat, $lng, $keyword);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error occurred: ' . $e->getMessage()], 500);
    }

    return $this->responder->__invoke($results);
  }
}