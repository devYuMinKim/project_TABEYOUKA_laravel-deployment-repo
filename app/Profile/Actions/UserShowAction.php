<?php

namespace App\Profile\Actions;

use App\Profile\Domains\Repositories\ShowUserData;
use App\Profile\Responders\UserShowResponder;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserShowAction
{
  protected $showUserData, $userShowResponder;

  public function __construct(
    ShowUserData $showUserData,
    UserShowResponder $userShowResponder
  ) {
    $this->showUserData = $showUserData;
    $this->userShowResponder = $userShowResponder;
  }

  public function __invoke(Request $request)
  {
    try {
      $request->validate([
        'user_id' => 'required',
      ]);
    } catch (ValidationException $e) {
      // 유효성 검사 실패 시
      $errors = $e->getMessage();
      return response()->json($errors, 422);
    }
    $result = $this->showUserData->showUser($request->user_id);
    return $this->userShowResponder->userShowResponse($result);
  }
}

?>
