<?php

namespace App\Review\Actions;

use Illuminate\Http\Request;
use App\Review\Domain\CreateReviewDomain;
use Illuminate\Validation\ValidationException;

class CreateReviewAction
{
  protected $domain;

  public function __construct(CreateReviewDomain $domain)
  {
    $this->domain = $domain;
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

    return $this->domain->createReview($review);
  }
}
