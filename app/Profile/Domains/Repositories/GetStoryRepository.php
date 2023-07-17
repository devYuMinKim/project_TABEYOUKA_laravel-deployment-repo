<?php

namespace App\Profile\Domains\Repositories;

use App\Profile\Domains\Entities\Stories;
use App\Restaurant\Actions\FindRestaurantByIdAction;
use App\Restaurant\Domain\Repositories\HotpepperRestaurantRepository;
use App\Review\Domain\Repositories\ReviewRepository;

class GetStoryRepository
{
  public function __construct(
    protected ReviewRepository $reviewRepository, 
    protected HotpepperRestaurantRepository $hotpepperRestaurantRepository) {

  }
  public function store($id)
  {
    $reviewIds = Stories::where('story_list_id', $id)->select('review_id')->get();
    $reviews = array();
    foreach ($reviewIds as $value) {
      $review = $this->reviewRepository->getReviewById($value->review_id);
      $restaurant = $this->hotpepperRestaurantRepository->find($review->restaurant_id);
      $review->restaurant_name = $restaurant['shop'][0]['name'];
      array_push($reviews, $review);
    };
    return $reviews;
  }
}

?>
