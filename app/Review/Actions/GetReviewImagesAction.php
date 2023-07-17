<?php

namespace App\Review\Actions;

use Illuminate\Http\Request;
use App\Review\Domain\Repositories\ReviewRepository as Repository;
use App\Review\Responders\GetReviewsResponder as Responder;

class GetReviewImagesAction
{
  public function __construct(
    protected Repository $repository,
    protected Responder $responder
  ) {
  }
  public function __invoke(Request $request)
  {
    $this->validateRequest($request);

    $review_id = $request->input('review_id');

    $response = $this->repository->getReviewImages($review_id);

    return $this->responder->respond($response);
  }

  public function validateRequest(Request $request)
  {
    $request->validate([
      'review_id' => 'required|integer',
    ]);
  }
}
