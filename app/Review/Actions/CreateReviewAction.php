<?php

namespace App\Review\Actions;

use Illuminate\Http\Request;
use App\Review\Domain\Review;
use App\Review\Responders\CreateReviewResponder;

class CreateReviewAction
{
  public function __construct(
    protected Review $domain,
    protected CreateReviewResponder $responder
  ) {
  }

  public function __invoke(Request $request)
  {
    $this->validateRequest($request);

    $review = $request->only(['content', 'score', 'restaurant_id', 'user_id']);

    try {
      $reponse = $this->domain->createReview($review);
    } catch (\Exception $e) {
      response()->json(['error' => $e->getMessage()], 500);
    }

    return $this->responder->respond($reponse);
  }

  public function validateRequest(Request $request)
  {
    $request->validate([
      'content' => 'string',
      'score' => 'integer',
      'restaurant_id' => 'required|integer',
      'user_id' => 'required|string',
    ]);
  }
}
