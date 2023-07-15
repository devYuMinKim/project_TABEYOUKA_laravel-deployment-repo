<?php

namespace App\Profile\Actions;

use App\Profile\Domains\Repositories\GetStoryListRepository;
use App\Profile\Responders\GetStoryListResponders;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class GetStoryListAction
{
  public function __construct(
    protected GetStoryListRepository $getStoryListRepository,
    protected GetStoryListResponders $getStoryListResponders
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

    $result = $this->getStoryListRepository->store($request->user_id);
    return $this->getStoryListResponders->getStoryListReponse($result);
  }
}

?>
