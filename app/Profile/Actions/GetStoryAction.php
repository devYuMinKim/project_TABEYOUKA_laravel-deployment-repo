<?php

namespace App\Profile\Actions;

use App\Profile\Domains\Repositories\GetStoryRepository as Repository;
use App\Profile\Responders\GetStoryResponder as Responder;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class GetStoryAction
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
        'story_list_id' => 'required',
      ]);
    } catch(ValidationException $e) {
      $errMsg = $e->getMessage();
      return response()->json(['error'=>$errMsg]);
    }


    $result = $this->repository->store($request->story_list_id);
    return $this->responder->getStoryResponse($result);
  }
}

?>
