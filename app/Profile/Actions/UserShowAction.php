<?php

namespace App\Profile\Actions;

use App\Profile\Domains\Entities\Users;
use App\Profile\Responders\UserShowResponder;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserShowAction
{
  protected $users, $userShowResponder;

  public function __construct(
    Users $users,
    UserShowResponder $userShowResponder
  ) {
    $this->users = $users;
    $this->userShowResponder = $userShowResponder;
  }

  public function __invoke(Request $request)
  {
    try {
      $request->validate([
        'id' => 'required',
      ]);
    } catch (ValidationException $e) {
      // 유효성 검사 실패 시
      $errors = $e->errors();
      return response()->json($errors, 422);
    }
    $result = $this->users->showUser($request->id);
    return $this->userShowResponder->userShowResponse($result);
  }
}

?>
