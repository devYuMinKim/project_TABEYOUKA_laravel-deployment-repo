<?php

namespace App\Review\Domain\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Review\Domain\Entities\Review;
use App\Restaurant\Domain\Entities\Restaurant;

class ReviewRepository
{
  public function createReview(array $review)
  {
    // Create a Restaurant info when restaurant is not exist
    try {
      Restaurant::findOrFail($review['restaurant_id']);
    } catch (ModelNotFoundException $e) {
      Restaurant::create([
        'id' => $review['restaurant_id'],
      ]);
    }

    $result = Review::create([...$review, 'like' => 0]);

    return $result;
  }

  /**
   * Get random reviews
   */
  public function getRandomReviews(int $count)
  {
    $uniqueUserIds = Review::select('user_id')
      ->distinct()
      ->get()
      ->pluck('user_id');

    $randomUserIds =
      $uniqueUserIds->count() >= $count
        ? $uniqueUserIds->random($count)
        : $uniqueUserIds;

    $reviews = collect([]);

    foreach ($randomUserIds as $userId) {
      $singleReview = Review::where('user_id', $userId)
        ->inRandomOrder()
        ->first();

      if ($singleReview) {
        $reviews->push($singleReview);
      }
    }

    return $reviews;
  }

  /**
   * Get reviews by user ids
   */
  public function getReviewsByUserIds(array $userIds)
  {
    if (count($userIds) === 0) {
      return collect([]);
    }

    return Review::whereIn('user_id', $userIds)->get();
  }

  /**
   * Get review by id
   */
  public function getReviewById($id)
  {
    $review = Review::find($id);

    return $review;
  }

  /**
   * Get all reviews
   */
  public function getReviews($range)
  {
    if (!isset($range['count'])) {
      return Review::all();
    }

    $count = $range['count'];
    $page = $range['page'] ?? 1;

    $reviews = Review::orderBy('created_at', 'desc')
      ->skip($count * ($page - 1))
      ->take($count)
      ->get();

    return $reviews;
  }
}
