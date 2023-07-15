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

    // 유저와 리뷰 테이블을 유저 아이디로 조인하여 카운트로 유저의 리뷰를 가져오기
    // $reviews = Users::join('reviews', 'users.id', '=', 'reviews.user_id')
    //   ->select(DB::raw('COUNT(*) as count'))
    //   ->where('users.id', $id)
    //   ->groupBy('users.id')
    //   ->first();

    return $userData;
  }
}

?>
