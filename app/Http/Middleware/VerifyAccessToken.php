<?php

namespace App\Http\Middleware;

use App\Profile\Domains\Entities\Users;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Exception\RequestException;

class VerifyAccessToken
{
  public function handle(Request $request, Closure $next)
  {
    $accessToken = $request->access_token;
    try {
      // token에 대한 유효성을 검증하고 그에 대한 정보를 반환
      $response = Http::get('https://oauth2.googleapis.com/tokeninfo', [
        'access_token' => $accessToken, // 구글에서 받은 accessToken
      ]);
    } catch (RequestException $e) {
      $errMsg = $e->getMessage();
      return response()->json(['error' => $errMsg], 401);
    }

    if ($response['expires_in'] > 0) {
      return $next($request);
    } else {
      // 토큰이 유효하지 않은 경우 처리할 작업 수행
      return response()->json(['message' => 'idToken is invalid'], 401);
    }
  }
}
