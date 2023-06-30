<?php

namespace App\Review\Actions;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Review\Domain\LikeReviewDomain;

class LikeReviewAction
{
  protected $domain;
  public function __construct(LikeReviewDomain $domain)
  {
    $this->domain = $domain;
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

    return $this->domain->likeReview($review);
  }
}
