<?php
namespace App\Search\Responders;

/**
 * 주변 식당 확인 결과 응답자 클래스
 * - 주변 식당 검색 결과를 적절한 형태로 가공하여 반환
 */
class NearbyRestaurantsResponder
{
  public function respond($restaurants)
  {
    return response()->json($restaurants);
  }
}