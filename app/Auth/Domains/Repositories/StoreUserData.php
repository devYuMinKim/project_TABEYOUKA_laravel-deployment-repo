<?php
namespace App\Auth\Domains\Repositories;

use App\profile\Domains\Entities\Users;

class storeUserData
{
  public function storeUserData($userData)
  {
    // 사용자 정보 생성
    $user = Users::create([
      'id' => $userData->id,
      'nickname' => $userData->nickname,
      'profile_image' => $userData->profile_image,
    ]);

    $result = $user->save();
    return $result;
  }
}
?>

