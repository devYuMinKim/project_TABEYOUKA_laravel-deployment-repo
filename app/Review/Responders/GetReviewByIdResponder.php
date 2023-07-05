<?php

namespace App\Review\Responders;

class GetReviewByIdResponder
{
  public function respond($result)
  {
    return response()->json($result);
  }
}
