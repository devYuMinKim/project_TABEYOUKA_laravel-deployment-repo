<?php

namespace App\Profile\Actions;

use App\Profile\Domains\UserUpdateDomain;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserUpdateAction
{
  protected $userUpdateDomain;

  public function __construct(UserUpdateDomain $userUpdateDomain) 
  {
    $this->userUpdateDomain = $userUpdateDomain;
  }

  public function update(Request $request)
  {
    try {
      $request->validate([
          'id' => 'required',
      ]);
    } catch (ValidationException $e) {
        // 유효성 검사 실패 시 처리 로직
        $errors = $e->errors();
        return response()->json($errors);
        // 오류 메시지를 반환하거나 다른 동작 수행
    }
    
    $fileName = $request->profile_image->store('public/images/profile');
    $filePath = 'http://localhost:8000/images/profile/'.basename($fileName);

    $userData = [
      'id' => $request->id,
      'nickname' => $request->nickname,
      'profile_image' => $filePath,
    ];

    $updatedUser = $this->userUpdateDomain->updateUserData((object)$userData);
    return response()->json($updatedUser, 200);
  }
}

?>