<?php

namespace App\Review\Domain;

use App\Review\Responders\GetReviewsResponder;
use App\Models\Review;

class GetReviewsDomain
{
  protected $responder;

  public function __construct(GetReviewsResponder $responder)
  {
    $this->responder = $responder;
  }

  public function getReviews()
  {
    $reviews = Review::all();

    return $this->responder->respond($reviews);
  }
}
