<?php

  namespace App\Profile\Responders;

  class UserUpdateResponder
  {
    public function userUpdateResponse($result)
    {
      if(!$result) {
        return response()->json(['message' => 'Update user failed'], 500);
      }

      return response()->json(['message' => 'Update user successfully'], 200);
    }
  }

?>