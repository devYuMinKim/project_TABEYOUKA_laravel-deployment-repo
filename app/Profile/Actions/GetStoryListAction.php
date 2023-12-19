<?php

namespace App\Profile\Actions;

use App\Profile\Domains\Repositories\GetStoryListRepository as Repository;
use App\Profile\Responders\GetStoryListResponders as Responder;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class GetStoryListAction
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
    } catch(ValidationException $e) {
      $errMsg = $e->getMessage();
      return response()->json(['error'=>$errMsg]);
    }

    $result = $this->repository->store($request->user_id);
    return $this->responder->getStoryListReponse($result);
  }
}

?>
