<?php

namespace App\Profile\Actions;

use App\Profile\Domains\Repositories\ShowUserDataRepository as Repository;
use App\Profile\Responders\UserShowResponder as Responder;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserShowAction
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
        'user_id' => 'required',
      ]);
    } catch (ValidationException $e) {
      // 유효성 검사 실패 시
      $errors = $e->getMessage();
      return response()->json($errors, 422);
    }
    $result = $this->repository->showUser($request->user_id);
    return $this->responder->userShowResponse($result);
  }
}

?>
