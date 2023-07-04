<?php

namespace App\Review\Actions;

use App\Review\Domain\Review;
use App\Review\Responders\GetReviewByIdResponder;

class GetReviewByIdAction
{
  public function __construct(
    protected Review $domain,
    protected GetReviewByIdResponder $responder
  ) {
  }
  public function __invoke($id)
  {
    $response = $this->domain->getReviewById($id);

    return $this->responder->respond($response);
  }
}
