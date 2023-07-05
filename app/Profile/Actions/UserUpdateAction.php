<?php

namespace App\Profile\Actions;

use App\Profile\Domains\Entities\Users;
use App\Profile\Responders\UserUpdateResponder;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserUpdateAction
{
  protected $users, $userUpdateResponder;

  public function __construct(
    Users $users,
    UserUpdateResponder $userUpdateResponder
  ) {
    $this->users = $users;
    $this->userUpdateResponder = $userUpdateResponder;
  }

  public function __invoke(Request $request)
  {
    try {
      $request->validate([
        'id' => 'required',
        'nickname' => 'required',
        'profile_image' => 'required',
      ]);
    } catch (ValidationException $e) {
      // 유효성 검사 실패 시 처리 로직
      $errors = $e->errors();
      return response()->json($errors, 422);
      // 오류 메시지를 반환하거나 다른 동작 수행
    }

    $fileName = $request->profile_image->store('public/images/profile');
    $filePath = 'http://localhost:8000/images/profile/' . basename($fileName);

    $userData = [
      'id' => $request->id,
      'nickname' => $request->nickname,
      'profile_image' => $filePath,
    ];

    $updatedUser = $this->users->updateUserData((object) $userData);
    return $this->userUpdateResponder->userUpdateResponse($updatedUser);
  }
}

?>
