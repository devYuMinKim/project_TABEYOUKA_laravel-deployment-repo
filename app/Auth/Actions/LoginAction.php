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

  public function store(Request $request)
  { 
    $imagePath = 'http://localhost:8000/images/profile/default_image.jpg'; // 배포시 경로 수정 필요

    

    try {
      $request->validate([
          'id' => 'required',
      ]);
    } catch (ValidationException $e) {
        // 유효성 검사 실패 시
        $errors = $e->errors();
        return response()->json($errors,422);
    }

    $user = Users::where('id',$request->id)->exists();
    if(!$user) {
      $userData = [
        'id' => $request->id,
        'nickname' => 'User'.uniqid(), 
        'profile_image' => $imagePath,
      ];
      $response = $this->users->storeUserData((object)$userData);
    }
    // 세션에 사용자의 토큰을 저장(구현해야함)
    // 로컬/세션 스토리지에 저장 해두고 백엔드 토큰과 비교, 경로 이동시 세션 비교는 미들웨어로 처리?
    // 쿠키는 웹브라우저에 없지 않나

    return $this->loginResponder->loginResponse($response);
  }
}

?>