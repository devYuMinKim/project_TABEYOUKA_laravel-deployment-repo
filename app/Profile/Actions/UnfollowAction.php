<?php

namespace App\Profile\Actions;

use App\Profile\Domains\Repositories\UnfollowRepository as Repository;
use App\Profile\Responders\UnfollowResponder as Responder;
use Illuminate\Http\Request;

class UnfollowAction
{
  public function __construct(
    protected Repository $repository,
    protected Responder $responder
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
