<?php

namespace App\Review\Actions;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
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
    try {
      $request->validate([
        'content' => 'string',
        'score' => 'integer',
        'restaurant_id' => 'required|integer',
        'user_id' => 'required|string',
      ]);
    } catch (ValidationException $e) {
      $errors = $e->errors();
      return response()->json($errors, 422);
    }

    $review = $request->only(['content', 'score', 'restaurant_id', 'user_id']);

    $reponse = $this->domain->createReview($review);

    return $this->responder->respond($reponse);
  }
}
