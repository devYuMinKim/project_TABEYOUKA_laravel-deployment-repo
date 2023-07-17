<?php

namespace App\Review\Actions;

use Illuminate\Http\Request;
use App\Review\Domain\Repositories\ReviewRepository as Repository;
use App\Review\Responders\GetReviewByResponder as Responder;

class GetReviewByAction
{
  public function __construct(
    protected Repository $repository,
    protected Responder $responder
  ) {
  }

  public function __invoke(Request $request)
  {
    $this->validateRequest($request);

    $review = $request->only(['review_id', 'user_id']);

    if (isset($review['review_id'])) {
      $response = $this->repository->getReviewById($review['review_id']);
    } elseif (isset($review['user_id'])) {
      $response = $this->repository->getReviewsByUserIds([$review['user_id']]);
    } else {
      return response()->json(
        [
          'error' =>
            'At least one value of review_id or user_id must be assigned.',
        ],
        400
      );
    }

    return $this->responder->respond($response);
  }

  public function validateRequest(Request $request)
  {
    $request->validate([
      'review_id' => 'integer',
      'user_id' => 'string',
    ]);
  }
}
