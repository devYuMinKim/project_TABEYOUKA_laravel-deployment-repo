<?php

namespace App\Auth\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use App\Auth\Domains\Repositories\storeUserDataRepository as Repository;
use App\Auth\Responders\LoginResponder as Responder;

class LoginAction
{
  protected $users, $loginResponder;
  public function __construct(
    protected Repository $repository,
    protected Responder $responder
  ) {
  }

  public function __invoke(Request $request)
  {
    try {
      $request->validate([
        'code' => 'required',
      ]);
    } catch (ValidationException $e) {
      // 유효성 검사 실패 시
      $errors = $e->errors();
      return response()->json($errors, 422);
    }

    $response = $this->repository->storeUserData($request->code);

    return $this->responder->loginResponse($response);
  }
}

?>
