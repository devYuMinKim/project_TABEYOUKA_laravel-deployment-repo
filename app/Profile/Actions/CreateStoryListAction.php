<?php

namespace App\Profile\Actions;

use App\Profile\Domains\Repositories\CreateStoryListRepository as Repository;
use App\Profile\Responders\CreateStoryListResponder as Responder;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CreateStoryListAction
{
  public function __construct(
    protected Repository $repository,
    protected Responder $responder,
  ) {
  }

  public function __invoke(Request $request)
  {
    try {
      $request->validate([
        'user_id' => 'required',
        'story_name' => 'required|max:10',
        'review_list' => 'required',
      ]);
    } catch(ValidationException $e) {
      $errMsg = $e->getMessage();
      return response()->json(['error'=>$errMsg]);
    }


    $result = $this->repository->create($request);
    return $this->responder->createStoryListResponse($result);
  }
}

?>
