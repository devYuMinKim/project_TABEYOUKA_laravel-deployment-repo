<?php

namespace App\Restaurant\Responders;

class CreateRestaurantResponder
{
  public function respond($result)
  {
    return response()->json(['message' => '식당이 생성되었습니다.']);
  }
}
