<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Main\Actions\SearchRestaurantsAction;
use App\Main\Actions\FindNearbyRestaurantsAction;

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
 * 가게 검색 기능(장르, 대형 지역, 중형 지역 선택 가능)
 */
Route::get('/search', function (Request $request, SearchRestaurantsAction $action) {
    $genre = $request->input('genre');
    $large_area = $request->input('large_area');
    $middle_area = $request->input('middle_area');

    return $action($genre, $large_area, $middle_area);
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

// TODO: 검색 메서드(가게명)
// TODO: 사용자 위치 기반으로 가게 추천
// TODO: 사용자 성향에 따른 가게 추천