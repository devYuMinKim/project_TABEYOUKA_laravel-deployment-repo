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

  /**
   * Get all reviews
   */
  public function getReviews()
  {
    $reviews = self::all();

    return $reviews;
  }

  /**
   * Create a review
   */
  public function createReview(array $review)
  {
    $restaurant_id = $review['restaurant_id'];

    $restaurant = Restaurant::find($restaurant_id);

    // 만약 해당 식당이 없다면, 식당을 생성한다.
    if (!$restaurant) {
      Restaurant::create([
        'id' => $restaurant_id,
      ]);
    }

    $result = self::create([...$review, 'like' => 0]);

    return $result;
  }
}
