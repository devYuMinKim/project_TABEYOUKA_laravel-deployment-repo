<?php

namespace App\Profile\Domains\Repositories;

use App\Profile\Domains\Entities\Story;
use App\Restaurant\Domain\Repositories\HotpepperRestaurantRepository;
use App\Review\Domain\Repositories\ReviewRepository;

class GetStoryRepository
{
  public function __construct(
    protected ReviewRepository $reviewRepository,
    protected HotpepperRestaurantRepository $hotpepperRestaurantRepository
  ) {
  }
  public function store($id)
  {
    $reviewIds = Story::where('story_list_id', $id)
      ->select('review_id')
      ->get();
    $reviews = [];
    foreach ($reviewIds as $value) {
      $reviewId = $value->review_id;
      $review = $this->reviewRepository->getReviewById($reviewId);
      $restaurantId = $review->restaurant->id;
      $restaurant = $this->hotpepperRestaurantRepository->find($restaurantId);
      $review->restaurant_name = $restaurant['shop'][0]['name'];
      array_push($reviews, $review);
    }
    return $reviews;
  }
}

?>
