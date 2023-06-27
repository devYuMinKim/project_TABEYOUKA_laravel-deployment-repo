<?php
// 검색 결과 응답자
namespace App\Main\Responders;

class SearchRestaurantsResponder
{
  public function respond($restaurants)
  {
    // 검색 결과를 적절한 형태로 가공하여 반환
    return response()->json($restaurants);
  }
}