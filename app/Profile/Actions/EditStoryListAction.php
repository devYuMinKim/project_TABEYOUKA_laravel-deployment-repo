<?php

namespace App\Profile\Actions;

use App\Profile\Domains\Repositories\EditStoryListRepository as Repository;
use App\Profile\Responders\EditStoryListResponder as Responder;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EditStoryListAction {
  public function __construct(
    protected Repository $repository,
    protected Responder $responder) {
  }

  public function __invoke(Request $request) {
    try {
      $request->validate([
        'id' => 'required',
        'story_name' => 'required|max:10',
        'review_list' => 'required',
      ]);
    } catch(ValidationException $e) {
      $errMsg = $e->getMessage();
      return response()->json(['error'=>$errMsg]);
    }

    $result = $this->repository->edit($request);

    return $this->responder->editStoryListResponse($result);
  }
}

?>
