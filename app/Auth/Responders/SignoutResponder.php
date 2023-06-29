<?php

namespace App\Auth\Responders;

class SignoutResponder
{
  public function signoutResponse($result)
  {
    if(!$result) {
      return response()->json(['message' => 'Failed to delete data'],422);
    }
    return response()->json(['message' => 'User has been deleted successfully']);
  }
}

?>