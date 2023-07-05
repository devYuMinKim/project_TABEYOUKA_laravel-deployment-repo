<?php

namespace App\Review\Actions;

use App\Review\Domain\Repositories\ReviewRepository as Repository;
use App\Review\Responders\GetReviewByIdResponder as Responder;

class GetReviewByIdAction
{
  public function __construct(
    protected Repository $repository,
    protected Responder $responder
  ) {
  }
  public function __invoke($id)
  {
    $response = $this->repository->getReviewById($id);

    return $this->responder->respond($response);
  }
}
