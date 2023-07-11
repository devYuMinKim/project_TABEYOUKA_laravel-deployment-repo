<?php
namespace App\Profile\Domains\Repositories;

use App\Profile\Domains\Entities\Users;

class FollowerRepository
{
  public function getFollower($id)
  {
    // users.id와 follows.to_user (팔로워 아이디)를 조인하여
    // users.id와 현재 유저 아이디가 같은 행의 follows.from_user 행만 출력
    $followers = Users::join('follows', 'users.id', '=', 'follows.to_user')
      ->select('follows.from_user') // 팔로잉 중인 사람
      ->where('users.id', $id)
      ->get();

    $followerData = Users::find($followers);

    return $followerData;
  }
}

?>
