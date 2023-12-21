<?php

namespace App\Profile\Domains\Repositories;

use App\Profile\Domains\Entities\User;
use App\Restaurant\Actions\FindRestaurantByIdAction;

class GetRestaurantCoordinatesRepository
{
  // 현재 사용자가 리뷰를 남긴 좌표를 가져옴
  public function __construct(
    protected FindRestaurantByIdAction $findRestaurantByIdAction
  ) {
  }
  public function get($userId)
  {
    $restaurantCoordinates = collect(); // 좌표 담는 배열

    $restaurantId = User::find($userId)->reviews()->pluck('restaurant_id');

    $uniqueRestaurantId = $restaurantId->unique();

    $uniqueRestaurantId->map(function ($id) use ($restaurantCoordinates) {
      $rInfo = $this->findRestaurantByIdAction->__invoke($id)['shop'][0]; // 이상하게도 shop 정보를 배열로 받아옴
      $rId = $id;
      $rImage = $rInfo['photo']['pc']['l'];
      $rName = $rInfo['name'];
      $lat = $rInfo['lat']; // 좌표를 각각 변수에 저장하고 $coordinates 배열에 할당
      $lng = $rInfo['lng'];
      $coordinates = [
        'id' => $rId,
        'name' => $rName,
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
