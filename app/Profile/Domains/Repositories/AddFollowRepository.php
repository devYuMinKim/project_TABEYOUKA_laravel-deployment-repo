<?php
namespace App\Profile\Domains\Repositories;

use App\Profile\Domains\Entities\Follows;

class AddFollowRepository
{
  public function store($data)
  {
    // Follow
    $follow = Follows::create([
      'from_user' => $data->id, // 팔로우 하는 사람
      'to_user' => $data->follow_id, // 팔로우 받는 사람
    ]);

    return $follow;
  }
}

?>
