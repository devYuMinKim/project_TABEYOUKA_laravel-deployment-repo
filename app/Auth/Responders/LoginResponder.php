<?php
namespace App\Auth\Responders;

class LoginResponder
{
  public function loginResponse($result)
  {
    if($result) {
      return response()->json(['message' => 'Add user successfully'], 200);
    } else {
      return response()->json(['message' => 'Store user failed'], 500);
    }
  }
}
?>