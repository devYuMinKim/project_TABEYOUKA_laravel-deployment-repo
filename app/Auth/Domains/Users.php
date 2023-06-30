<?php

namespace App\Auth\Domains;

use App\Profile\Domains\Users as profileUsers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Users extends profileUsers
{
  // protected $table = 'users';

  // protected $fillable = [
  //   'id',
  //   'nickname',
  //   'profile_image',
  // ];

  public function storeUserData($userData)
  {
    // 사용자 정보 생성
    $user = self::create([
      'id' => $userData->id,
      'nickname' => $userData->nickname,
      'profile_image' => $userData->profile_image,
    ]);

    $result = $user->save();
    return $result;
  }

  public function destroyUser($id)
  {
    // 사용자 정보 삭제
    try {
      // 현재 클래스를 가리킴
      $user = self::findOrFail($id);
    } catch (ModelNotFoundException $e) {
      return response()->json(['error' => 'User not found'], 404);
    }

    $result = $user->delete();

    return $result;
  }
}

?>
