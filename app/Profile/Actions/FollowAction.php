<?php

namespace App\Profile\Actions;

use App\Profile\Domains\Repositories\AddFollowRepository;
use App\Profile\Responders\FollowResponder;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FollowAction
{
  protected $followRepository, $followResponder;
  public function __construct(
    protected AddFollowRepository $repository,
    protected FollowResponder $responder
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
