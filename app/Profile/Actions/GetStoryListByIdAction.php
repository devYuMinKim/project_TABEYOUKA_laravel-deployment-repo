<?php

namespace App\Profile\Actions;

use App\Profile\Domains\Repositories\GetStoryListByIdRepository;
use App\Profile\Responders\GetStoryListByIdResponder;

class GetStoryListByIdAction
{
  public function __construct(
    protected GetStoryListByIdRepository $getStoryListByIdRepository,
    protected GetStoryListByIdResponder $getStoryListByIdResponder
  ) {
  }

  public function __invoke($id)
  {
    if(!$id) {
      return response()->json(['error'=>'id field is required']);
    }
  
    $result = $this->getStoryListByIdRepository->store($id);
    return $this->getStoryListByIdResponder->getStoryListByIdReponse($result);
  }
}

?>
