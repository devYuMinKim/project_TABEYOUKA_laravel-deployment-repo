<?php

use App\Auth\Actions\SignoutAction;
use App\Profile\Actions\UserShowAction;
use App\Profile\Actions\UserUpdateAction;
use App\Auth\Actions\LoginAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Search\Actions\SearchRestaurantsAction;
use App\Search\Actions\FindNearbyRestaurantsAction;
use App\Recommendation\Actions\RecommendRestaurantsAction;
use App\Restaurant\Actions\FindRestaurantByIdAction;
use App\Search\Responders\SearchRestaurantsResponder;
use App\Search\Responders\FindNearbyRestaurantsResponder;
use App\Recommendation\Responders\RecommendRestaurantsResponder;
use App\Restaurant\Responders\FindRestaurantByIdResponder;
use App\Services\RecruitApiService;
use App\Restaurant\Actions\CreateRestaurantAction;
use App\Review\Actions\GetReviewsAction;
use App\Review\Actions\GetReviewByIdAction;
use App\Review\Actions\CreateReviewAction;
use App\Like\Actions\LikeReviewAction;
use App\Like\Actions\UnlikeReviewAction;

/**
 * 가게 검색 기능(장르, 대형 지역, 중형 지역, 가게명를 선택하여 검색 가능)
 */

Route::get('/search', function (
  Request $request,
  SearchRestaurantsAction $action,
  SearchRestaurantsResponder $responder
) {
  try {
    $genre = $request->input('genre');
    $large_area = $request->input('large_area');
    $middle_area = $request->input('middle_area');
    $keyword = $request->input('name');

    $result = $action($genre, $large_area, $middle_area, $keyword);
  } catch (\Exception $e) {
    return response()->json(['error' => 'Error occurred: ' . $e->getMessage()], 500);
  }
  
  return $responder($result);
});

/**
 * 사용자 위치 기반 가게 검색 기능
 */

Route::get('/search/nby', function (
  Request $request,
  FindNearbyRestaurantsAction $action,
  FindNearbyRestaurantsResponder $responder
) {
  $lat = floatval($request->input('lat'));
  $lng = floatval($request->input('lng'));

  $range = 5; // 기본 검색 범위 (5km)

  $result = $action($lat, $lng, $range);
  return $responder($result);
});

/**
 * 사용자 성향에 따른 가게 추천 기능
 */

Route::get('/recommend/{user_id}', function (
  string $user_id,
  RecruitApiService $recruitApiService,
  RecommendRestaurantsAction $action,
  RecommendRestaurantsResponder $responder
) {
  $restaurants = $action($user_id, $recruitApiService);
  return $responder($restaurants);
});

/**
 * 가게 아이디로 가게 정보 찾기 기능
 */
Route::get('/restaurant/{id}', function (
  string $id,
  FindRestaurantByIdAction $action,
  FindRestaurantByIdResponder $responder
) {
  $restaurant = $action($id);
  return $responder($restaurant);
});

/**
 * 리뷰 기능
 */

// 리뷰 조회
Route::get('/review', GetReviewsAction::class);

// 리뷰 아이디로 리뷰 조회
Route::get('/review/{id}', GetReviewByIdAction::class);

// 리뷰 생성
Route::post('/review', CreateReviewAction::class);

// 리뷰 공감
Route::post('/review/like', LikeReviewAction::class);

// 리뷰 공감취소
Route::delete('/review/like', UnLikeReviewAction::class);

/**
 * 가게 기능
 */

// 가게 생성
Route::post('/restaurant', CreateRestaurantAction::class);

/**
 * 사용자 관련 기능
 */
Route::post('/user', LoginAction::class);
Route::get('/user', UserShowAction::class);
Route::patch('/user', UserUpdateAction::class);
Route::delete('/user', SignoutAction::class);
