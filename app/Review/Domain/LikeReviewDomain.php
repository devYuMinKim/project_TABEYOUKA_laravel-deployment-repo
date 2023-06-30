<?php

namespace App\Review\Domain;

use App\Models\Like;
use App\Review\Responders\LikeReviewResponder;

class LikeReviewDomain
{
  protected $responder;

  public function __construct(LikeReviewResponder $responder)
  {
    $this->responder = $responder;
  }

  public function likeReview(array $review)
  {
    $result = new Like($review);

    $result->save();

    return $this->responder->respond($result);
  }
}
