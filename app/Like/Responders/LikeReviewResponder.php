<?php

namespace App\Like\Responders;

class LikeReviewResponder
{
  public function respond($result)
  {
    return response()->json(['message' => '리뷰을 공감하였습니다.'], 201);
  }
}
