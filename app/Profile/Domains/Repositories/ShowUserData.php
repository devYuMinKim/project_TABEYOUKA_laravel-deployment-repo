<?php

namespace App\Profile\Domains\Repositories;

use App\Profile\Domains\Entities\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ShowUserData
{
  public function showUser($id)
  {
    try {
      $userData = User::findOrFail($id);
    } catch (ModelNotFoundException $e) {
      return response()->json(['error' => 'User not found'], 404);
    }

    return $userData;
  }
}

?>
