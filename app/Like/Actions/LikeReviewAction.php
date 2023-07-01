<?php

namespace App\Like\Actions;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Like\Domain\Like;
use App\Like\Responders\LikeReviewResponder;

class LikeReviewAction
{
  protected $domain;
  protected $responder;

  public function __construct(Like $domain, LikeReviewResponder $responder)
  {
    $this->domain = $domain;
    $this->responder = $responder;
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

    $response = $this->domain->likeReview($review);

    return $this->responder->respond($response);
  }
}
