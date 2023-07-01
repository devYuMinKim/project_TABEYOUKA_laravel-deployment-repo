<?php

namespace App\Review\Actions;

use App\Review\Domain\Review;
use App\Review\Responders\GetReviewsResponder;

class GetReviewsAction
{
  protected $domain;
  protected $responder;

  public function __construct(Review $domain, GetReviewsResponder $responder)
  {
    $this->domain = $domain;
    $this->responder = $responder;
  }
  public function __invoke()
  {
    $response = $this->domain->getReviews();

    return $this->responder->respond($response);
  }
}
