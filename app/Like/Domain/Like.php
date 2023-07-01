<?php

namespace App\Like\Domain;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Review\Domain\Review;
use App\Profile\Domains\Users;

class Like extends Model
{
  use HasFactory;

  protected $table = 'likes';
  protected $fillable = ['review_id', 'user_id', 'created_at', 'updated_at'];

  public function review()
  {
    return $this->belongsTo(Review::class);
  }

  public function user()
  {
    return $this->belongsTo(Users::class);
  }

  /**
   * Like a review
   */
  public function likeReview(array $review)
  {
    $isExist = self::where('review_id', $review['review_id'])
      ->where('user_id', $review['user_id'])
      ->exists();

    if ($isExist) {
      return response()->json(['message' => '이미 좋아요를 눌렀습니다.'], 422);
    }

    $result = self::create($review);

    return $result;
  }
}
