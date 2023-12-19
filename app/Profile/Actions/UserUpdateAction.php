<?php

namespace App\Profile\Actions;

use App\Profile\Domains\Repositories\UpdateUserDataRepository as Repository;
use App\Profile\Responders\UserUpdateResponder as Responder;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserUpdateAction
{
  public function __construct(
    protected Repository $repository,
    protected Responder $responder
  ) {
  }

  public function __invoke(Request $request)
  {
    try {
      $request->validate([
        'id' => 'required',
        'nickname' => 'required',
      ]);
    } catch (ValidationException $e) {
      // 유효성 검사 실패 시 처리 로직
      $errMsg = $e->errors();
      return response()->json($errMsg, 422);
      // 오류 메시지를 반환하거나 다른 동작 수행
    }

    $updatedUser = $this->repository->updateUserData($request);
    return $this->responder->userUpdateResponse($updatedUser);
  }
}

?>
