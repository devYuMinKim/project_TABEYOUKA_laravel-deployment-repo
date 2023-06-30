<?php

namespace App\Review\Actions;

use App\Review\Domain\GetReviewsDomain;

class GetReviewsAction
{
  protected $domain;
  public function __construct(GetReviewsDomain $domain)
  {
    $this->domain = $domain;
  }
  public function __invoke()
  {
    return $this->domain->getReviews();
  }
}
