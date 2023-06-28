<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Search\Actions\SearchRestaurantsAction;
use App\Search\Actions\FindNearbyRestaurantsAction;
use App\Auth\Actions\LoginAction;
use App\Auth\Actions\SignoutAction;
use App\Profile\Actions\UserUpdateAction;
use App\Profile\Actions\UserShowAction;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/**
 * 가게 검색 기능(장르, 대형 지역, 중형 지역, 가게명를 선택하여 검색 가능)
 */
Route::get('/search', function (Request $request, SearchRestaurantsAction $action) {
    // request에서 각 요소를 가져옴
    $genre = $request->input('genre');
    $large_area = $request->input('large_area');
    $middle_area = $request->input('middle_area');
    $keyword = $request->input('name');

    // 검색 액션 실행하여 결과 반환
    return $action($genre, $large_area, $middle_area, $keyword);
});

/**
 * 사용자 위치 기반 가게 검색 기능
 */
Route::get('/search/nby', function (Request $request, FindNearbyRestaurantsAction $action) {
    $lat = floatval($request->input('lat'));
    $lng = floatval($request->input('lng'));

    $range = 5; // 기본 검색 범위 (5km)

    return $action($lat, $lng, $range);
});

// TODO: 사용자 성향에 따른 가게 추천

// 사용자에 관련된 api
Route::post('/user', [LoginAction::class, 'store']);
Route::patch('/user', [UserUpdateAction::class, 'update']);
Route::get('/user/{id}', [UserShowAction::class, 'getUserById']);
Route::delete('/user/{id}', [SignoutAction::class, 'getUserById']);
