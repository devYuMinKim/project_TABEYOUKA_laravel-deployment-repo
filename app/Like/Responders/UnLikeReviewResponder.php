<?php

namespace App\Like\Responders;

class UnLikeReviewResponder
{
  public function respond($result)
  {
    return response()->json(['message' => '리뷰을 공감 취소하였습니다.'], 204);
  }
}
