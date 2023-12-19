<?php
namespace App\Profile\Domains\Repositories;

use App\Profile\Domains\Entities\User;

class FollowingRepository
{
  public function getFollowing($id)
  {
    // users.id와 follows.from_user (팔로잉 아이디)를 조인하여
    // users.id와 현재 유저 아이디가 같은 행의 follows.to_user 행만 출력
    $following = User::join('follows', 'users.id', '=', 'follows.from_user')
      ->select('follows.to_user') // 팔로잉 중인 사람
      ->where('users.id', $id)
      ->get();

    $followingData = User::find($following);

    return $followingData;
  }
}

?>
