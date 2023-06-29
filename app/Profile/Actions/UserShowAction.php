<?php

namespace App\Profile\Actions;

use App\Profile\Domains\Users;
use App\Profile\Responders\UserShowResponder;

class UserShowAction
{
  protected $users, $userShowResponder;

  public function __construct(Users $users, UserShowResponder $userShowResponder)
  {
    $this->users = $users;
    $this->userShowResponder = $userShowResponder;
  }

  public function getUserById($id)
  {
    if(empty($id)) {
      return response()->json(['message' => 'id field is required']);
    }
    $result = $this->users->showUser($id);
    return $this->userShowResponder->userShowResponse($result);
  }
}

?>