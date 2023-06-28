<?php

namespace App\Profile\Domains;

use App\Profile\Responders\UserShowResponder;
use App\Models\User;

class UserShowDomain
{
  protected $userShowResponder;
  public function __construct(UserShowResponder $userShowResponder)
  {
    $this->userShowResponder = $userShowResponder;
  }

  public function showUser($id)
  { 
    $userData = User::findOrFail($id);
    return $this->userShowResponder->userShowResponse($userData);
  }
}

?>