<?php

namespace App\Profile\Actions;

use App\Profile\Domains\Repositories\FollowingRepository;
use App\Profile\Responders\FollowingResponder;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FollowingAction
{
  protected $followingRepository, $followingResponder;
  public function __construct(
    FollowingRepository $followingRepository,
    FollowingResponder $followingResponder
  ) {
    $this->followingRepository = $followingRepository;
    $this->followingResponder = $followingResponder;
  }

  public function __invoke(Request $request)
  {
    try {
      $request->validate([
        'user_id' => 'required',
      ]);
    } catch (ValidationException $e) {
      $errMsg = $e->errors();
      return response()->json($errMsg, 422);
    }
    $result = $this->followingRepository->getFollowing($request->user_id);
    return $this->followingResponder->followingResponse($result);
  }
}

?>
