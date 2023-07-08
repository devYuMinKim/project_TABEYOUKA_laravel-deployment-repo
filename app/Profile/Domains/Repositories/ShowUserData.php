<?php

namespace App\Profile\Domains\Repositories;

use App\Profile\Domains\Entities\Users;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
class ShowUserData
{
  public function showUser($id)
  {
    try {
      $userData = Users::findOrFail($id);
    } catch (ModelNotFoundException $e) {
      return response()->json(['error' => 'User not found'], 404);
    }

    $follower = Users::join('follows', 'users.id', '=', 'follows.to_user')
      ->select(DB::raw('COUNT(*) as count')) // 팔로잉 중인 사람
      ->where('users.id', $id)
      ->groupBy('users.id')
      ->first();

    $following = Users::join('follows', 'users.id', '=', 'follows.from_user')
      ->select(DB::raw('COUNT(*) as count')) // 팔로잉 중인 사람
      ->where('users.id', $id)
      ->groupBy('users.id')
      ->first();

    $userData->follower = $follower->count;
    $userData->following = $following->count;

    return $userData;
  }
}

?>
