<?php

namespace App\Review\Responders;

class LikeReviewResponder
{
  public function respond($result)
  {
    return response()->json($result);
  }
}
