<?php

use App\Auth\Actions\SignoutAction;
use App\Like\Actions\CheckLikeReviewAction;
use App\Like\Actions\ToggleLikeReviewAction;
use App\Profile\Actions\UserShowAction;
use App\Profile\Actions\UserUpdateAction;
use App\Auth\Actions\LoginAction;
use App\Review\Actions\GetReviewImagesAction;
use App\Review\Actions\UploadImageAction;
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
use App\Review\Actions\GetReviewByAction;
use App\Review\Actions\CreateReviewAction;
use App\Review\Actions\GetFollowedUsersReviewsAction;
use App\Profile\Actions\CreateStoryListAction;
use App\Profile\Actions\EditStoryListAction;
use App\Profile\Actions\FollowAction;
use App\Profile\Actions\FollowerAction;
use App\Profile\Actions\FollowingAction;
use App\Profile\Actions\GetRestaurantCoordinatesAction;
use App\Profile\Actions\GetStoryAction;
use App\Profile\Actions\GetStoryListAction;
use App\Profile\Actions\GetStoryListByIdAction;
use App\Profile\Actions\UnfollowAction;

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
 * 가게 검색 기능(장르, 대형 지역, 중형 지역, 가게명를 선택하여 검색 가능)
 */

Route::get('/search', function (
  Request $request,
  SearchRestaurantsAction $action,
  SearchRestaurantsResponder $responder
) {
  try {
    $genre = $request->input('genre');
    $area = $request->input('area');
    $lat = $request->input('lat');
    $lng = $request->input('lng');
    $keyword = $request->input('name');
    $start = $request->input('start');
    $count = $request->input('count');

    $result = $action($genre, $area, $lat, $lng, $keyword, $start, $count);
  } catch (\Exception $e) {
    return response()->json(
      ['error' => 'Error occurred: ' . $e->getMessage()],
      500
    );
  }
  return $responder($result);
});

// 사용자 로그인 & 최초 로그인 정보
Route::post('/user', LoginAction::class);

Route::middleware('accesstoken')->group(function () {
  /**
   * 스토리 관련 기능
   */
  // 스토리 리스트 불러오기
  Route::get('/storylist', GetStoryListAction::class);
  // 스토리 리스트 아이디를 받아서 특정 스토리 리스트 불러오기 (수정 시 기존 정보 렌더링 사용)
  Route::get('/storylist/{id}', GetStoryListByIdAction::class);
  // 스토리 리스트 생성
  Route::post('/storylist', CreateStoryListAction::class);
  // 스토리 리스트 수정
  Route::patch('/storylist', EditStoryListAction::class);
  // 스토리 리스트 아이디를 받아서 해당 리뷰 목록 반환
  Route::get('/story', GetStoryAction::class);
  /**
   * 지도 관련 기능
   */
  // 지도 좌표 반환
  Route::get('/map', GetRestaurantCoordinatesAction::class);
  /**
   * 팔로워, 팔로잉 관련 기능
   */
  Route::get('/follower', FollowerAction::class); // 팔로워 불러오기
  Route::get('/following', FollowingAction::class); // 팔로잉 불러오기
  Route::post('/follow', FollowAction::class); // 팔로우하기
  Route::delete('/follow', UnfollowAction::class); // 언팔로우

  /**
   * 사용자 관련 기능
   */
  Route::get('/user', UserShowAction::class);
  Route::patch('/user', UserUpdateAction::class);
  Route::delete('/user', SignoutAction::class);

  /**
   * 리뷰 기능
   */

  // 리뷰 범위 조회
  Route::get('/reviews', GetReviewsAction::class);

  // 리뷰 상세 조회 (id, user_id)
  Route::get('/review', GetReviewByAction::class);

  // 팔로우한 사용자의 리뷰 조회
  Route::get(
    '/reviews/followed/{fromUserId}',
    GetFollowedUsersReviewsAction::class
  );

  // 리뷰 생성
  Route::post('/review', CreateReviewAction::class);

  Route::post('/review/like/check', CheckLikeReviewAction::class);

  // // 리뷰 공감
  // Route::post('/review/like', LikeReviewAction::class);

  // // 리뷰 공감취소
  // Route::post('/review/unlike', UnLikeReviewAction::class);

  Route::post('/review/like', ToggleLikeReviewAction::class);

  // 리뷰 사진 조회
  Route::get('/review/images', GetReviewImagesAction::class);

  // 리뷰 사진 업로드
  Route::post('/review/image', UploadImageAction::class);

  /**
   * 가게 기능
   */

  // 가게 생성
  Route::post('/restaurant', CreateRestaurantAction::class);

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
});
