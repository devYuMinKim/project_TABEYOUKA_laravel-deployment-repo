<?php
namespace App\Profile\Domains\Repositories;

use App\Profile\Domains\Entities\Users;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
class UpdateUserData
{
  public function updateUserData($userData)
  {
    try {
      $user = Users::findOrFail($userData->id);
    } catch (ModelNotFoundException $e) {
      return response()->json($e, 404);
    }

    $user->nickname = $userData->nickname;
    $user->bio = $userData->bio;

    if (!empty($userData->profile_image)) {
      $storedFileName = $userData->profile_image->store(
        'profile_images/' . date('Ym'),
        's3'
      );
      $storedPath = Storage::disk('s3')->url($storedFileName);
      $user->profile_image = $storedPath;
    }

    $result = $user->save();

    return $result;
  }
}

?>
