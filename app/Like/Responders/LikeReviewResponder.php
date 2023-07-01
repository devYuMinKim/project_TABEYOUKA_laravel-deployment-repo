<?php

namespace App\Like\Responders;

class LikeReviewResponder
{
  public function respond($result)
  {
    return response()->json($result);
  }
}
