<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Client;
use App\Auth\Domains\Users;
use GuzzleHttp\Exception\RequestException;

class VerifyIDToken
{
  public function handle(Request $request, Closure $next): Response
  {
    $idToken = $request->idToken;
    $clientId = env('GOOGLE_CLIENT_ID');

    try {
      $client = new Client();

      $response = $client->get('https://oauth2.googleapis.com/tokeninfo', [
        'query' => [
          'id_token' => $idToken, // 구글에서 받은 idToken
        ],
      ]);
      //
      $data = json_decode($response->getBody()->getContents(), true);
      // 토큰 유효성 확인
      // aud == 애플리케이션 고유 식별자
      if (isset($data['aud']) && $data['aud'] === $clientId) {
        // 토큰이 유효한 경우 처리할 작업 수행, 유효할 경우 $request에 id 키를 가진 이메일 값을 추가
        $request->merge(['id' => $data['email']]);
        $user = Users::where('id', $request->id)->exists();
        if ($user) {
          return response()->json(['message' => 'User logged in successfully']);
        }
        return $next($request);
      } else {
        // 토큰이 유효하지 않은 경우 처리할 작업 수행
        return response()->json(
          // 프론트에서 해당 응답을 받으면 idToken을 다시 요청하면 되지 않을까.. 생각합니다
          ['message' => 'idToken is invalid'],
          401
        );
      }
    } catch (RequestException $e) {
      return response()->$e;
    }
  }
}
