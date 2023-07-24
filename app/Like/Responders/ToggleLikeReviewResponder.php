<?php

namespace App\Like\Responders;

class ToggleLikeReviewResponder
{
  public function respond($result)
  {
    if ($result) {
      return response()->json(['message' => '리뷰 공감을 했습니다.'], 201);
    } else {
      return response()
        ->json()
        ->setStatusCode(204);
    }
  }
}
