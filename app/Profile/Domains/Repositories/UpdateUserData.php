<?php
namespace App\Profile\Domains\Repositories;

use App\Profile\Domains\Entities\Users;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class updateUserData
{
  public function updateUserData($userData)
  {
    try {
      $user = Users::findOrFail($userData->id);
    } catch (ModelNotFoundException $e) {
      return response()->json($e, 404);
    }

    $user->nickname = $userData->nickname;
    $user->profile_image = $userData->profile_image;
    $user->bio = $userData->bio;
    $result = $user->save();

    return $result;
  }
}

?>
