<?php

namespace App\Profile\Actions;

use App\Profile\Domains\Repositories\updateUserData;
use App\Profile\Responders\UserUpdateResponder;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserUpdateAction
{
  protected $updateUserData, $userUpdateResponder;

  public function __construct(
    updateUserData $updateUserData,
    UserUpdateResponder $userUpdateResponder
  ) {
    $this->updateUserData = $updateUserData;
    $this->userUpdateResponder = $userUpdateResponder;
  }

  public function __invoke(Request $request)
  {
    try {
      $request->validate([
        'id' => 'required',
        'nickname' => 'required',
        'bio' => 'required',
        // 'profile_image' => 'required',
      ]);
    } catch (ValidationException $e) {
      // 유효성 검사 실패 시 처리 로직
      $errMsg = $e->errors();
      return response()->json($errMsg, 422);
      // 오류 메시지를 반환하거나 다른 동작 수행
    }
    $userData = [
      'id' => $request->id,
      'nickname' => $request->nickname,
      'bio' => $request->bio,
    ];

    if ($request->profile_image) {
      $fileName = $request->profile_image->store('public/images/profile');
      $filePath = 'http://localhost:8000/images/profile/' . basename($fileName);
      $userData['profile_image'] = $filePath;
    }

    $updatedUser = $this->updateUserData->updateUserData((object) $userData);
    return $this->userUpdateResponder->userUpdateResponse($updatedUser);
  }
}

?>
