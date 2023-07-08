<?php

namespace App\Profile\Actions;

use App\Profile\Domains\Users;
use App\Profile\Domains\Repositories\FollowerRepository;
use App\Profile\Responders\FollowerResponder;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FollowerAction
{
  protected $followerRepository, $followerResponder;
  public function __construct(
    FollowerRepository $followerRepository,
    FollowerResponder $followerResponder
  ) {
    $this->followerRepository = $followerRepository;
    $this->followerResponder = $followerResponder;
  }

  public function __invoke(Request $request)
  {
    try {
      $request->validate([
        'id' => 'required',
      ]);
    } catch (ValidationException $e) {
      $errMsg = $e->errors();
      return response()->json($errMsg, 422);
    }

    $result = $this->followerRepository->getFollower($request->id);
    return $this->followerResponder->followerResponse($result);
  }
}

?>
