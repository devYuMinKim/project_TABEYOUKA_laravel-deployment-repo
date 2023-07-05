<?php

namespace App\Like\Actions;

use Illuminate\Http\Request;
use App\Exceptions\LikeNotFoundException;
use App\Like\Domain\Like;
use App\Like\Responders\UnLikeReviewResponder;

class UnLikeReviewAction
{
  public function __construct(
    protected Like $domain,
    protected UnLikeReviewResponder $responder
  ) {
  }

  public function __invoke(Request $request)
  {
    $this->validateRequest($request);

    $review = $request->only(['review_id', 'user_id']);

    try {
      $response = $this->domain->unLikeReview($review);
    } catch (LikeNotFoundException $e) {
      return response()->json(['error' => '공감이 존재하지 않습니다.'], 422);
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
