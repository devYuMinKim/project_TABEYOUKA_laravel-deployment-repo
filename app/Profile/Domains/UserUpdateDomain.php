<?php

namespace App\Profile\Domains;

use App\Profile\Responders\UserUpdateResponder;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserUpdateDomain
{
  protected $userUpdateResponder;

  public function __construct(UserUpdateResponder $userUpdateResponder)
  {
    $this->userUpdateResponder = $userUpdateResponder;
  }

  public function updateUserData($userData)
  {
    try {
      $user = User::findOrFail($userData->id);
    } catch (ModelNotFoundException $e) {
        return response()->json($e, 404);
    }

    $user->nickname = $userData->nickname;
    //$user->profile_image = $userData->profile_image;
    $result = $user -> save();

    return $this->userUpdateResponder->userUpdateResponse($result);
  }
}

?>