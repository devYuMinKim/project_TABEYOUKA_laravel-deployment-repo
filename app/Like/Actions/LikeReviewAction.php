<?php

namespace App\Like\Actions;

use Illuminate\Http\Request;
use App\Exceptions\LikeAlreadyExistsException;
use App\Like\Domain\Like;
use App\Like\Responders\LikeReviewResponder;

class LikeReviewAction
{
  public function __construct(
    protected Like $domain,
    protected LikeReviewResponder $responder
  ) {
  }

  public function __invoke(Request $request)
  {
    $this->validateRequest($request);

    $review = $request->only(['review_id', 'user_id']);

    try {
      $response = $this->domain->likeReview($review);
    } catch (LikeAlreadyExistsException $e) {
      return response()->json(['error' => '이미 공감한 리뷰입니다.'], 422);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 500);
    }

    return $this->responder->respond($response);
  }

  public function validateRequest(Request $request)
  {
    $request->validate([
      'review_id' => 'required|integer',
      'user_id' => 'required|string',
    ]);
  }
}
