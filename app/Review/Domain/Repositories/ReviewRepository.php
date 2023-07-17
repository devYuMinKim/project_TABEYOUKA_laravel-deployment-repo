<?php

namespace App\Review\Domain\Repositories;

use App\Review\Domain\Entities\ReviewImages;
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

    $images = self::getReviewImages($id);

    $review->images = $images['images'];

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

    foreach ($reviews as $review) {
      $images = self::getReviewImages($review->id);
      $review->images = $images['images'];
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
}
