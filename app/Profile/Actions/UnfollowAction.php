<?php

namespace App\Profile\Actions;

use App\Profile\Domains\Repositories\UnfollowRepository;
use App\Profile\Responders\UnfollowResponder;
use Illuminate\Http\Request;

class UnfollowAction
{
  public function __construct(
    protected UnfollowRepository $repository,
    protected UnfollowResponder $responder
  ) {
  }

  public function __invoke(Request $request)
  {
    $request->validate([
      'id' => 'required',
      'follow_id' => 'required',
    ]);

    $result = $this->repository->delete($request);
    return $this->responder->response($result);
  }
}

?>
