<?php
namespace App\Profile\Domains\Repositories;

use App\Profile\Domains\Entities\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class UpdateUserDataRepository
{
  public function updateUserData($userData)
  {
    try {
      $user = User::findOrFail($userData->id);
    } catch (ModelNotFoundException $e) {
      return response()->json($e, 404);
    }

    $user->nickname = $userData->nickname;
    $user->bio = $userData->bio;

    if (!empty($userData->profile_image)) {
      // $storedFileName = $userData->profile_image->store(
      //   'profile_images/' . date('Ym'),
      //   's3'
      // );
      // $storedPath = Storage::disk('s3')->url($storedFileName);
      $storedFile = $userData->file('profile_image')->store('public/images/profile');
      $filePath = 'http://localhost:8000/storage/images/profile/'.basename($storedFile);
      $user->profile_image = $filePath;
    } else {
      $user->profile_image = '';
    }

    $result = $user->save();

    return $result;
  }
}

?>
