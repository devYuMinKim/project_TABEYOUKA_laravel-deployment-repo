<?php

namespace App\Review\Domain;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Profile\Domains\Users;
use App\Restaurant\Domain\Restaurant;

class Review extends Model
{
  use HasFactory;

  protected $table = 'reviews';
  protected $fillable = [
    'id',
    'content',
    'score',
    'like',
    'restaurant_id',
    'user_id',
    'created_at',
    'updated_at',
  ];

  public function user()
  {
    return $this->belongsTo(Users::class);
  }

  public function restaurant()
  {
    return $this->belongsTo(Restaurant::class);
  }

  public function getReviewById($id)
  {
    $review = self::find($id);

    return $review;
  }

  /**
   * Get all reviews
   */
  public function getReviews()
  {
    $reviews = self::all();

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

    return self::whereIn('user_id', $userIds)->get();
  }

  /**
   * Create a review
   */
  public function createReview(array $review)
  {
    $restaurant_id = $review['restaurant_id'];

    $isExist = Restaurant::find($restaurant_id);

    // 만약 해당 식당이 없다면, 식당을 생성한다.
    if (!$isExist) {
      Restaurant::create([
        'id' => $restaurant_id,
      ]);
    }

    $result = self::create([...$review, 'like' => 0]);

    return $result;
  }

  /**
   * Get random reviews
   */
  public function getRandomReviews(int $count)
  {
      $uniqueUserIds = self::select('user_id')->distinct()->get()->pluck('user_id');
      
      $randomUserIds = $uniqueUserIds->count() >= $count ? $uniqueUserIds->random($count) : $uniqueUserIds;
      
      $reviews = collect([]);

      foreach ($randomUserIds as $userId) {
          $singleReview = self::where('user_id', $userId)->inRandomOrder()->first();

          if ($singleReview) {
              $reviews->push($singleReview);
          }
      }

      return $reviews;
  }
}
