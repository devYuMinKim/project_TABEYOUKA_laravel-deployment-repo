<?php

namespace App\Auth\Actions;

use App\Auth\Domains\Users;
use App\Auth\Responders\SignoutResponder;

class SignoutAction
{ 
  protected $users, $signoutResponder;
  
  public function __construct(Users $users, SignoutResponder $signoutResponder)
  {
    $this->users = $users;
    $this->signoutResponder = $signoutResponder;
  }

  public function getUserById($id)
  {
    if(empty($id)) {
      return response()->json(['message' => 'id field is required'], 422);
    }
    $result = $this->users->destroyUser($id);
    return $this->signoutResponder->signoutResponse($result);
  }
}

?>