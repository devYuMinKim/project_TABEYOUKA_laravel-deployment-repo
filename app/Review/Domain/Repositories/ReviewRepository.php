<?php

namespace App\Review\Domain\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Restaurant\Domain\Entities\Restaurant;
use App\Review\Domain\Entities\Review;
use App\Review\Domain\Entities\ReviewImages;
use App\Profile\Domains\Entities\Users;

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

    if (!$review) {
      return null;
    }

    $images = self::getReviewImages($id);
    $user = self::getReviewUserData($review->user_id);
    $restaurant = self::getReviewRestaurantData($review->restaurant_id);

    unset($review->user_id);
    unset($review->restaurant_id);
    $review->images = $images['images'];
    $review->user = $user;
    $review->restaurant = $restaurant;

    return $review;
  }

  public function getReviewsByRestaurantId($restaurant_id)
  {
    $reviews = Review::where('restaurant_id', $restaurant_id)->get();

    foreach ($reviews as $review) {
      $images = self::getReviewImages($review->id);
      $user = self::getReviewUserData($review->user_id);
      $restaurant = self::getReviewRestaurantData($review->restaurant_id);

      unset($review->user_id);
      unset($review->restaurant_id);
      $review->images = $images['images'];
      $review->user = $user;
      $review->restaurant = $restaurant;
    }

    return $reviews;
  }

  /**
   * Get all reviews
   */
  public function getReviews($range)
  {
    $count = $range['count'] ?? 10;
    $page = $range['page'] ?? 1;

    $reviews = Review::orderBy('created_at', 'desc')
      ->skip($count * ($page - 1))
      ->take($count)
      ->get();

    foreach ($reviews as $review) {
      $user = self::getReviewUserData($review->user_id);
      $restaurant = self::getReviewRestaurantData($review->restaurant_id);
      $images = self::getReviewImages($review->id);

      unset($review->user_id);
      unset($review->restaurant_id);
      $review->images = $images['images'];
      $review->user = $user;
      $review->restaurant = $restaurant;
    }

    return $reviews;
  }

  /**
   * Upload Images
   * TODO: 이미지 storage 서버로 분리해야 함.
   */
  public function uploadImage($image, $review_id)
  {
    $storedFileName = $image->store('review_images/' . date('Ym'));

    $uploadedImage = ReviewImages::create([
      'review_id' => $review_id,
      'image_url' => $storedFileName,
    ]);

    return $uploadedImage;
  }

  /**
   * Get Review Images
   */
  public function getReviewImages($review_id)
  {
    $reviewImages = ReviewImages::select('image_url')
      ->where('review_id', $review_id)
      ->pluck('image_url')
      ->toArray();

    $result = [
      'images' => $reviewImages ?? [],
    ];

    return $result;
  }

  public function getReviewUserData($user_id)
  {
    return Users::select(
      'id',
      'nickname',
      'profile_image',
      'bio',
      'follower',
      'following'
    )
      ->where('id', $user_id)
      ->first();
  }

  public function getReviewRestaurantData($restaurant_id)
  {
    return Restaurant::select('id', 'score')
      ->where('id', $restaurant_id)
      ->first();
  }
}
