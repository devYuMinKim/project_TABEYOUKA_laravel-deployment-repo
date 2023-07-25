<?php
namespace App\Auth\Domains\Repositories;

use App\profile\Domains\Entities\Users;
use Illuminate\Support\Facades\Http;

class storeUserDataRepository
{
  public function storeUserData($code)
  {
    $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
      'code' => $code,
      'client_id' => env('GOOGLE_CLIENT_ID'),
      'client_secret' => env('GOOGLE_CLIENT_SECRET'),
      'redirect_uri' => 'http://localhost:5173',
      'grant_type' => 'authorization_code',
    ]);

    $tokenInfo = Http::asForm()->get(
      'https://oauth2.googleapis.com/tokeninfo',
      [
        'access_token' => $response['access_token'], // 구글에서 받은 idToken
      ]
    );

    $email = $tokenInfo['email'];
    $imagePath = '  '; // 배포시 경로 수정 필요

    $user = Users::where('id', $email);

    if (!$user) {
      // 사용자 정보 생성
      $user = Users::create([
        'id' => $email,
        'nickname' => 'User' . uniqid(),
        'profile_image' => $imagePath,
        'bio' => ' ',
      ]);
      $user->save();
    }

    $tokens = [
      'id' => $tokenInfo['email'],
      'access_token' => $response['access_token'],
      'refresh_token' => $response['refresh_token'],
    ];
    return $tokens;
  }
}
?>

