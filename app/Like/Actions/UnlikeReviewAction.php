<?php

namespace App\Like\Actions;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Like\Domain\Like;
use App\Like\Responders\UnlikeReviewResponder;

class UnlikeReviewAction
{
  public function __construct(
    protected Like $domain,
    protected UnlikeReviewResponder $responder
  ) {
  }

  public function __invoke(Request $request)
  {
    try {
      $request->validate([
        'review_id' => 'required|integer',
        'user_id' => 'required|string',
      ]);
    } catch (ValidationException $e) {
      $errors = $e->errors();
      return response()->json($errors, 422);
    }

    $review = $request->only(['review_id', 'user_id']);

    $response = $this->domain->unLikeReview($review);

    return $this->responder->respond($response);
  }
}
