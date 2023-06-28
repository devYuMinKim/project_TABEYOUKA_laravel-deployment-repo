<?php

namespace App\Auth\Domains;

use App\Auth\Responders\SignoutResponder;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SignoutDomain
{ 
  protected $signoutResponder;

  public function __construct(SignoutResponder $signoutResponder)
  {
    $this->signoutResponder = $signoutResponder;
  }
  public function destroyUser($id)
  {
    try {
      $user = User::findOrFail($id);
    } 
    catch (ModelNotFoundException $e) {
        return response()->json($e, 404);
    }
    
    $result = $user->delete();

    return $this->signoutResponder->signoutResponse($result);
  }
}

?>