<?php

namespace App\Review\Responders;

class GetReviewByResponder
{
  public function respond($result)
  {
    return response()->json($result);
  }
}
