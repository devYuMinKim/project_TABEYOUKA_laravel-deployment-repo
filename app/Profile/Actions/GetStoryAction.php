<?php

namespace App\Profile\Actions;

use App\Profile\Domains\Repositories\GetStoryRepository;
use App\Profile\Responders\GetStoryResponder;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class GetStoryAction
{
  public function __construct(
    protected GetStoryRepository $getStoryRepository,
    protected GetStoryResponder $getStoryResponder
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


    $result = $this->getStoryRepository->store($request->story_list_id);
    return $this->getStoryResponder->getStoryResponse($result);
  }
}

?>
