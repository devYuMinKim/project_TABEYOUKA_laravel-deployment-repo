<?php

namespace App\Review\Domain;

use App\Models\Restaurant;
use App\Restaurant\Domain\CreateRestaurantDomain;
use App\Review\Responders\CreateReviewResponder;
use App\Models\Review;

class CreateReviewDomain
{
  protected $responder;
  protected $createRestaurantDomain;

  public function __construct(
    CreateReviewResponder $responder,
    CreateRestaurantDomain $createRestaurantDomain
  ) {
    $this->responder = $responder;
    $this->createRestaurantDomain = $createRestaurantDomain;
  }

  public function createReview(array $review)
  {
    $restaurant_id = $review['restaurant_id'];
    $restaurant = Restaurant::find($restaurant_id);

    // 만약 해당 식당이 없다면, 식당을 생성한다.
    if (!$restaurant) {
      $this->createRestaurantDomain->createRestaurant([
        'id' => $restaurant_id,
      ]);
    }

    $result = new Review([...$review, 'like' => 0]);

    $result->save();

    return $this->responder->respond($result);
  }
}
