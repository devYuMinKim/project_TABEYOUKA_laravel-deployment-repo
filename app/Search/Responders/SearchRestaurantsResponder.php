<?php

namespace App\Search\Responders;

/**
 * 검색 결과 응답자 클래스
 * - 검색 결과를 적절한 형태로 가공하여 반환
 */
class SearchRestaurantsResponder
{
  public function __invoke($result)
  {
      return response()->json($result);
  }
}