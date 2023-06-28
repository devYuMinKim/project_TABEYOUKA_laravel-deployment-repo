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

    return $action->search($genre, $large_area, $middle_area);
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
 
/**
 * 가게명으로 검색 기능
 */
Route::get('/search/name', function (Request $request, \App\Services\RecruitApiService $recruitApiService) {
    $name = $request->input('name');

    if ($name) {
        $response = $recruitApiService->searchRestaurantsByName($name);
    } else {
        $response = null;
    }

    return response()->json($response);
});

// TODO: 사용자 성향에 따른 가게 추천