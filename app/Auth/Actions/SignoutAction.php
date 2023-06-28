<?php

namespace App\Auth\Actions;

use Illuminate\Http\Request;
use App\Auth\Domains\SignoutDomain;
use App\Models\User;

class SignoutAction
{ 
  protected $signoutDomain;
  
  public function __construct(SignoutDomain $signoutDomain)
  {
    $this->signoutDomain = $signoutDomain;
  }

  public function getUserById($id)
  {
    if(empty($id)) {
      return response()->json(['message' => 'id field is required'], 422);
    }
    return $this->signoutDomain->destroyUser($id);
  }
}

?>