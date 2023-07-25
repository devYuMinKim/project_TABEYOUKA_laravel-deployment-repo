<?php

namespace App\Profile\Actions;

use App\Profile\Domains\Repositories\EditStoryListRepository;
use App\Profile\Responders\EditStoryListResponder;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EditStoryListAction {
  public function __construct(
    protected EditStoryListRepository $editStoryListRepository, 
    protected EditStoryListResponder $editStoryListResponder) {
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

    $result = $this->editStoryListRepository->edit($request);

    return $this->editStoryListResponder->editStoryListResponse($result);
  }
}

?>