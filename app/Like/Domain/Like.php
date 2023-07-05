<?php

namespace App\Like\Domain;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\LikeAlreadyExistsException;
use App\Exceptions\LikeNotFoundException;
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
      throw new LikeAlreadyExistsException();
    }

    $result = self::create($review);

    return $result;
  }

  public function unLikeReview(array $review)
  {
    $like = self::where('review_id', $review['review_id'])
      ->where('user_id', $review['user_id'])
      ->first();

    if (!$like) {
      throw new LikeNotFoundException();
    }

    $result = $like->delete();

    return $result;
  }
}
