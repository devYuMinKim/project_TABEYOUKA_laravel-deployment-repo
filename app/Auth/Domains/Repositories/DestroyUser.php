<?php
namespace App\Auth\Domains\Repositories;

use App\profile\Domains\Entities\Users;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class storeUserData
{
  public function destroyUser($id)
  {
    // 사용자 정보 삭제
    try {
      // 현재 클래스를 가리킴
      $user = Users::findOrFail($id);
    } catch (ModelNotFoundException $e) {
      return response()->json(['error' => 'User not found'], 404);
    }

    $result = $user->delete();

    return $result;
  }
}
?>

