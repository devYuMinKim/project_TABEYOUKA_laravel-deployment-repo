<?php

namespace App\Recommendation\Responders;

class RecommendRestaurantsResponder
{
  /**
   * 응답 객체를 생성하여 반환
   */
  public function __invoke($restaurants)
  {
    return response()->json($restaurants);
  }
}