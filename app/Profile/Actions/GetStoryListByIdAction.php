<?php

namespace App\Profile\Actions;

use App\Profile\Domains\Repositories\GetStoryListByIdRepository as Repository;
use App\Profile\Responders\GetStoryListByIdResponder as Responder;

class GetStoryListByIdAction
{
  public function __construct(
    protected Repository $repository,
    protected Responder $responder
  ) {
  }

  public function __invoke($id)
  {
    if(!$id) {
      return response()->json(['error'=>'id field is required']);
    }

    $result = $this->repository->store($id);
    return $this->responder->getStoryListByIdReponse($result);
  }
}

?>
