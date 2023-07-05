<?php

namespace App\Review\Responders;

class GetFollowedUsersReviewsResponder
{
  public function respond($result)
  {
    return response()->json($result);
  }
}
