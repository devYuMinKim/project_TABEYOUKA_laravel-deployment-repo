<?php

namespace App\Review\Actions;

use App\Review\Domain\Review;
use App\Review\Responders\GetReviewsResponder;

class GetReviewsAction
{
  public function __construct(
    protected Review $domain,
    protected GetReviewsResponder $responder
  ) {
  }
  public function __invoke()
  {
    $response = $this->domain->getReviews();

    return $this->responder->respond($response);
  }
}
