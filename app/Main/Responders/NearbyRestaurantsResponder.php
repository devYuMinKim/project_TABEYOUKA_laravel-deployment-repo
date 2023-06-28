<?php
// 주변 식당 확인 결과 응답자
namespace App\Main\Responders;

class NearbyRestaurantsResponder
{
  public function respond($restaurants)
  {
    // 주변 식당 확인 결과를 적절한 형태로 가공하여 반환
    return response()->json($restaurants);
  }
}