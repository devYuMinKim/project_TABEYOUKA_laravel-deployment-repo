<?php

namespace App\Profile\Actions;

use App\Profile\Domains\Repositories\FollowerRepository as Repository;
use App\Profile\Responders\FollowerResponder as Responder;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FollowerAction
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
      $errMsg = $e->errors();
      return response()->json($errMsg, 422);
    }

    $result = $this->repository->getFollower($request->user_id);
    return $this->responder->followerResponse($result);
  }
}

?>
