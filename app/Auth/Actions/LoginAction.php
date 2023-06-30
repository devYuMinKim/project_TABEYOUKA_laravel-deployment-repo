<?php

namespace App\Auth\Actions;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Auth\Domains\Users;
use App\Auth\Responders\LoginResponder;

class LoginAction
{
  protected $users, $loginResponder;
  public function __construct(Users $users, LoginResponder $loginResponder)
  {
    $this->users = $users;
    $this->loginResponder = $loginResponder;
  }

  public function __invoke(Request $request)
  {
    $imagePath = 'http://localhost:8000/images/profile/default_image.jpg'; // 배포시 경로 수정 필요

    try {
      $request->validate([
        'id' => 'required',
      ]);
    } catch (ValidationException $e) {
      // 유효성 검사 실패 시
      $errors = $e->errors();
      return response()->json($errors, 422);
    }

    $userData = [
      'id' => $request->id,
      'nickname' => 'User' . uniqid(),
      'profile_image' => $imagePath,
    ];
    $response = $this->users->storeUserData((object) $userData);

    return $this->loginResponder->loginResponse($response);
  }
}

?>
