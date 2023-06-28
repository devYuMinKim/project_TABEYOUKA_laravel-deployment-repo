<?php

namespace App\Auth\Actions;

use App\Auth\Domains\LoginDomain;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class LoginAction
{ 
  protected $loginDomain;
  public function __construct(LoginDomain $loginDomain)
  {
    $this->loginDomain = $loginDomain;
  }

  public function store(Request $request)
  { 
    $imagePath = 'http://localhost:8000/images/profile/default_image.jpg'; // 배포시 경로 수정 필요

    try {
      $request->validate([
          'id' => 'required',
      ]);
    } catch (ValidationException $e) {
        // 유효성 검사 실패 시 처리 로직
        $errors = $e->errors();
        return response()->json($errors,422);
        // 오류 메시지를 반환하거나 다른 동작 수행
    }

    // $user = User::where('id',$validated['id'])->exists();
    // if($user) {
    //   // 세션에 사용자의 토큰을 저장하는 함수로 연결(구현해야함)
    // }

    $userData = [
      'id' => $request->id,
      'nickname' => 'User'.uniqid(), 
      'profile_image' => $imagePath,
    ];
  
    $response = $this->loginDomain->storeUserData((object)$userData);
    return response()->json($response, 200);
  }
}

?>