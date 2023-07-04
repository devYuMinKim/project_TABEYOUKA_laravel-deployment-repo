<?php

namespace App\Review\Domain\Repositories;

use App\Review\Domain\Entities\Follow;
use Illuminate\Support\Facades\DB;

class FollowRepository
{
  public function findByFromUser(string $fromUser): array
  {
    $follows = DB::table('follows')->where('from_user', $fromUser)->get();

    $result = [];

    foreach ($follows as $follow) {
      $result[] = new Follow($follow->from_user, $follow->to_user);
    }

    return $result;
  }
}