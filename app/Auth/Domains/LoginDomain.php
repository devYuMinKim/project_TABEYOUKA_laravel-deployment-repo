<?php 
namespace App\Auth\Domains;

use App\Models\User;
use App\Auth\Responders\LoginResponder;

class LoginDomain
{ 
  protected $loginResponder;

  public function __construct(LoginResponder $loginResponder)
  {
    $this->loginResponder = $loginResponder;
  }

  public function storeUserData($userData)
  {
    $user = new User([
      'id' => $userData->id,
      'nickname' => $userData->nickname,
      'profile_image' => $userData->profile_image,
    ]);

    $result = $user->save();
    return $this->loginResponder->loginResponse($result);
  }
}
?>

