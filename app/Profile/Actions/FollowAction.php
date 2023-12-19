<?php

namespace App\Profile\Actions;

use App\Profile\Domains\Repositories\AddFollowRepository as Repository;
use App\Profile\Responders\FollowResponder as Responder;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FollowAction
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
        'follow_id' => 'required',
      ]);
    } catch (ValidationException $e) {
      $errMsg = $e->errors();
      return response()->json($errMsg, 422);
    }

    $result = $this->repository->store($request);
    return $this->responder->response($result);
  }
}

?>
