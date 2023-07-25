<?php

namespace App\Review\Actions;

use Illuminate\Http\Request;
use App\Review\Domain\Repositories\ReviewRepository as Repository;
use App\Review\Responders\GetReviewsResponder as Responder;

class GetReviewsAction
{
  public function __construct(
    protected Repository $repository,
    protected Responder $responder
  ) {
  }
  public function __invoke(Request $request)
  {
    $this->validateRequest($request);

    $range = $request->only(['count', 'page']);

    $response = $this->repository->getReviews($range);

    return $this->responder->respond($response);
  }

  public function validateRequest(Request $request)
  {
    $request->validate([
      'count' => 'integer',
      'page' => 'integer',
    ]);
  }
}
