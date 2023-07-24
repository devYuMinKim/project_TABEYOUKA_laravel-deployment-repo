<?php

namespace App\Like\Responders;

class CheckLikeReviewResponder
{
  public function respond($result)
  {
    if ($result) {
      return response()->json(true);
    } else {
      return response()->json(false);
    }
  }
}
