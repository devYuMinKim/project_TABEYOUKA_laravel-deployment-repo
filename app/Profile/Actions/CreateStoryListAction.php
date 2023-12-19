<?php

namespace App\Profile\Actions;

use App\Profile\Domains\Repositories\CreateStoryListRepository;
use App\Profile\Responders\CreateStoryListResponder;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CreateStoryListAction
{
  public function __construct(
    protected CreateStoryListRepository $createStoryListRepository,
    protected CreateStoryListResponder $createStoryListResponder,
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


    $result = $this->createStoryListRepository->create($request);
    return $this->createStoryListResponder->createStoryListResponse($result);
  }
}

?>
