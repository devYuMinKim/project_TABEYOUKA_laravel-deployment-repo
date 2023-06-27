<?php
// 메인 페이지에서의 검색 액션
namespace App\Main\Actions;

use App\Services\RecruitApiService;
use App\Main\Responders\SearchRestaurantsResponder;

class SearchRestaurantsAction
{
  protected $recruitApiService;
  protected $responder;

  public function __construct(RecruitApiService $recruitApiService, SearchRestaurantsResponder $responder)
  {
    $this->recruitApiService = $recruitApiService;
    $this->responder = $responder;
  }

  public function search(?string $genre = null, ?string $large_area = null, ?string $middle_area = null) {
    $results = $this->recruitApiService->searchRestaurantsByLocationCode($genre, $large_area, $middle_area);
    return $this->responder->respond($results);
  }
}