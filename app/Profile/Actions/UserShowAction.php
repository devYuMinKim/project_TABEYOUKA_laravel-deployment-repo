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
        'id' => 'required',
      ]);
    } catch (ValidationException $e) {
      // 유효성 검사 실패 시
      $errors = $e->errors();
      return response()->json($errors, 422);
    }
    $result = $this->showUserData->showUser($request->id);
    return $this->userShowResponder->userShowResponse($result);
  }
}

?>
