<?php

namespace App\Profile\Actions;

use App\Profile\Domains\UserShowDomain;

class UserShowAction
{
  protected $userShowDomain;

  public function __construct(UserShowDomain $userShowDomain)
  {
    $this->userShowDomain = $userShowDomain;
  }

  public function getUserById($id)
  {
    if(empty($id)) {
      return response()->json(['message' => 'id field is required']);
    }
    return $this->userShowDomain->showUser($id);
  }
}

?>