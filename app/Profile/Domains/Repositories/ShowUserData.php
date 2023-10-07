<?php

namespace App\Profile\Domains\Repositories;

use App\Profile\Domains\Entities\Users;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ShowUserData
{
  public function showUser($id)
  {
    try {
      $userData = Users::findOrFail($id);
    } catch (ModelNotFoundException $e) {
      return response()->json(['error' => 'User not found'], 404);
    }

    return $userData;
  }
}

?>
