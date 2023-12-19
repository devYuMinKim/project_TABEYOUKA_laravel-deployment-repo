<?php

namespace App\Auth\Actions;

use App\Auth\Domains\Repositories\DestroyUser as Repository;
use App\Auth\Responders\SignoutResponder as Responder;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SignoutAction
{
  public function __construct(protected Repository $repository, protected Responder $responder)
  {
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

    $result = $this->repository->destroyUser($request['id']);
    return $this->responder->signoutResponse($result);
  }
}

?>
