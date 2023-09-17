<?php

namespace App\Review\Actions;

use Illuminate\Http\Request;

use App\Review\Domain\Repositories\ReviewRepository as Repository;
use App\Review\Responders\CreateReviewResponder as Responder;

class CreateReviewAction
{
  public function __construct(
    protected Repository $repository,
    protected Responder $responder
  ) {
  }

  public function __invoke(Request $request)
  {
    $this->validateRequest($request);

    $review = $request->only(['content', 'score', 'restaurant_id', 'user_id']);

    try {
      $reponse = $this->repository->createReview($review);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 500);
    }

    return $this->responder->respond($reponse);
  }

  public function validateRequest(Request $request)
  {
    $request->validate([
      'content' => 'string|nullable',
      'score' => 'integer|nullable',
      'restaurant_id' => 'required|string',
      'user_id' => 'required|string',
    ]);
  }
}
