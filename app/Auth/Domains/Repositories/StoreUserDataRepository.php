<?php
namespace App\Auth\Domains\Repositories;

use App\profile\Domains\Entities\User;
use Illuminate\Support\Facades\Http;

class StoreUserDataRepository
{
  public function storeUserData($code)
  {
    // get ACCESS & REFRESH token
    $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
      'code' => $code,
      'client_id' => env('GOOGLE_CLIENT_ID'),
      'client_secret' => env('GOOGLE_CLIENT_SECRET'),
      'redirect_uri' => env('GOOGLE_REDIRECT_URI'),
      'grant_type' => 'authorization_code',
    ]);

    $tokenInfo = Http::post('https://oauth2.googleapis.com/tokeninfo', [
      'id_token' => $response['id_token'], // 구글에서 받은 idToken
    ]);

    $email = $tokenInfo['email'];

    $user = User::where('id', $email)->first();

    if (!$user) {
      // 사용자 정보 생성
      $user = User::create([
        'id' => $email,
        'nickname' => 'User' . uniqid(),
        'bio' => ' ',
      ]);
      $user->save();
    }

    $tokens = [
      'id' => $email,
      'access_token' => $response['access_token'],
      'refresh_token' => $response['refresh_token'],
    ];

    return $tokens;
  }
}
?>

