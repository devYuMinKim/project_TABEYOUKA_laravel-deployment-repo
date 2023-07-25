<?php

namespace App\Review\Responders;

class GetReviewsResponder
{
  public function respond($result)
  {
    return response()->json($result);
  }
}
