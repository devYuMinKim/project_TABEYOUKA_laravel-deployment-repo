<?php

namespace App\Profile\Domains;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Users extends Model
{ 
  protected $table = 'users';

  protected $fillable = [
    'id',
    'nickname',
    'profile_image',
  ];
  public function showUser($id)
  { 
    try {
      $userData = Self::findOrFail($id);
    } 
    catch (ModelNotFoundException $e) {
        return response()->json(['error' => 'User not found'], 404);
    }
    return $userData;
  }
  public function updateUserData($userData)
  {
    try {
      $user = Self::findOrFail($userData->id);
    } catch (ModelNotFoundException $e) {
        return response()->json($e, 404);
    }

    $user->nickname = $userData->nickname;
    $user->profile_image = $userData->profile_image;
    $result = $user -> save();

    return $result;
  }
}

?>