<?php

namespace App\Restaurant\Domain\Repositories;

use App\Exceptions\RestaurantAlreadyExistsException;
use App\Restaurant\Domain\Entities\Restaurant;

class RestaurantRepository
{
  public function createRestaurant(array $restaurant)
  {
    $isExist = Restaurant::find($restaurant['id']);

    if ($isExist) {
      throw new RestaurantAlreadyExistsException();
    }

    $result = Restaurant::create([...$restaurant, 'score' => 0]);

    return $result;
  }
}
