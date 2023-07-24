<?php

namespace App\Profile\Domains\Repositories;

use App\Restaurant\Actions\FindRestaurantByIdAction;
use App\Review\Domain\Entities\Review;

class GetRestaurantCoordinatesRepository
{
  public function __construct(
    protected FindRestaurantByIdAction $findRestaurantByIdAction
  ) {
  }
  public function get($userId)
  {
    $restaurantCoordinates = collect(); // 좌표 담는 배열

    $restaurantId = Review::where('user_id', $userId)->pluck('restaurant_id'); // 사용자의 리뷰 중 레스토랑 아이디 get

    $uniqueRestaurantId = $restaurantId->unique();

    $uniqueRestaurantId->map(function ($id) use ($restaurantCoordinates) {
      $rInfo = $this->findRestaurantByIdAction->__invoke($id)['shop'][0]; // 이상하게도 shop 정보를 배열로 받아옴
      $rId = $id;
      $rImage = $rInfo['photo']['pc']['l'];
      $rname = $rInfo['name'];
      $lat = $rInfo['lat']; // 좌표를 각각 변수에 저장하고 $coordinates 배열에 할당
      $lng = $rInfo['lng'];
      $coordinates = [
        'id' => $rId,
        'name' => $rname,
        'logo_image' => $rImage,
        'lat' => $lat,
        'lng' => $lng,
      ];
      $restaurantCoordinates->push($coordinates);
    });

    return $restaurantCoordinates;
  }
}

?>
