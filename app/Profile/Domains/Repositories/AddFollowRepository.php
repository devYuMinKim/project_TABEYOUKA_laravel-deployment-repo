<?php
namespace App\Profile\Domains\Repositories;

use App\Profile\Domains\Entities\Follow;

class AddFollowRepository
{
  public function store($data)
  {
    // Follow
    $follow = Follow::create([
      'from_user' => $data->id, // 팔로우 하는 사람
      'to_user' => $data->follow_id, // 팔로우 받는 사람
    ]);

    return $follow;
  }
}

?>
