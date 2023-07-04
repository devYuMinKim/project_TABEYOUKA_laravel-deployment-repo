<?php

namespace App\Review\Responders;

class CreateReviewResponder
{
  public function respond($result)
  {
    return response()->json(['message' => '리뷰가 생성되었습니다.']);
  }
}
