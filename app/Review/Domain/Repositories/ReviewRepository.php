<?php

namespace App\Review\Domain\Repositories;

use App\Like\Domain\Entities\Like;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Restaurant\Domain\Entities\Restaurant;
use App\Review\Domain\Entities\Review;
use App\Review\Domain\Entities\ReviewImages;
use App\Profile\Domains\Entities\Users;
use Illuminate\Support\Facades\Storage;

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
   * Get review by id
   */
  public function getReviewById($id, $user_id = null)
  {
    $review = Review::find($id);

    if (!$review) {
      return null;
    }

    $images = self::getReviewImages($id);
    $user = self::getReviewUserData($review->user_id);
    $restaurant = self::getReviewRestaurantData($review->restaurant_id);
    // $liked = $user_id
    //   ? $review
    //     ->likes()
    //     ->where('user_id', $user_id)
    //     ->exists()
    //   : false;

    // FIXME: 테스트용 나중에 지울 것; user_id를 불러오는 방법을 찾아야 함. 로그인 로직 관련에서 해결가능할 것으로 추정
    $user_id = $user_id ?? 'laravel1@gmail.com';

    $liked = Like::where('review_id', $id)
      ->where('user_id', $user_id)
      ->exists();

    unset($review->user_id);
    unset($review->restaurant_id);
    $review->images = $images['images'];
    $review->user = $user;
    $review->restaurant = $restaurant;
    $review->liked = $liked;

    return $review;
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

    $review_ids = Review::whereIn('user_id', $randomUserIds)
      ->inRandomOrder()
      ->pluck('id')
      ->toArray();

    $reviews = collect([]);
    foreach ($review_ids as $id) {
      $review = self::getReviewById($id);
      $reviews->push($review);
    }

    return $reviews;
  }

  /**
   * Get reviews by user ids
   */
  public function getReviewsByUserIds(array $userIds, $range)
  {
    $count = $range['count'] ?? 10;
    $page = $range['page'] ?? 1;

    $review_ids = Review::whereIn('user_id', $userIds)
      ->skip($count * ($page - 1))
      ->take($count)
      ->orderBy('created_at', 'desc')
      ->pluck('id')
      ->toArray();

    $reviews = collect([]);
    foreach ($review_ids as $id) {
      $review = self::getReviewById($id);
      $reviews->push($review);
    }

    return $reviews;
  }

  public function getReviewsByRestaurantId($restaurant_id)
  {
    $review_ids = Review::where('restaurant_id', $restaurant_id)
      ->orderBy('created_at', 'desc')
      ->pluck('id')
      ->toArray();

    $reviews = collect([]);
    foreach ($review_ids as $id) {
      $review = self::getReviewById($id);
      $reviews->push($review);
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

    $review_ids = Review::orderBy('created_at', 'desc')
      ->skip($count * ($page - 1))
      ->take($count)
      ->pluck('id')
      ->toArray();

    $reviews = collect([]);
    foreach ($review_ids as $id) {
      $review = self::getReviewById($id);
      $reviews->push($review);
    }

    return $reviews;
  }

  /**
   * Upload Images
   */
  public function uploadImage($image, $review_id)
  {
    // $storedFileName = $image->store('review_images/' . date('Ym'), 's3');
    // $storedPath = Storage::disk('s3')->url($storedFileName);

    $storedFileName = $image->store('public/images/profile');
    $storedPath = 'http://localhost:8000/storage/images/profile/'.basename($storedFileName);

    $uploadedImage = ReviewImages::create([
      'review_id' => $review_id,
      'image_url' => $storedPath,
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
