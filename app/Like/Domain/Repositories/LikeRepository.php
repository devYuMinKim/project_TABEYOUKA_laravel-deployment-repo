<?php

namespace App\Like\Domain\Repositories;

use App\Exceptions\LikeAlreadyExistsException;
use App\Exceptions\LikeNotFoundException;
use App\Like\Domain\Entities\Like;

class LikeRepository
{
  public function checkLikeReview(array $review)
  {
    $isExist = Like::where('review_id', $review['review_id'])
      ->where('user_id', $review['user_id'])
      ->exists();

    return $isExist;
  }

  public function toggleLikeReview(array $review)
  {
    $like = Like::where('review_id', $review['review_id'])
      ->where('user_id', $review['user_id'])
      ->exists();

    if ($like) {
      $result = $this->unLikeReview($review);
    } else {
      $result = $this->likeReview($review);
    }

    return $result;
  }

  public function likeReview(array $review)
  {
    $isExist = Like::where('review_id', $review['review_id'])
      ->where('user_id', $review['user_id'])
      ->exists();

    if ($isExist) {
      throw new LikeAlreadyExistsException();
    }

    $result = Like::create($review);

    return $result;
  }
  public function unLikeReview(array $review)
  {
    $like = Like::where('review_id', $review['review_id'])
      ->where('user_id', $review['user_id'])
      ->first();

    if (!$like) {
      throw new LikeNotFoundException();
    }

    $like->delete();

    return false;
  }
}
