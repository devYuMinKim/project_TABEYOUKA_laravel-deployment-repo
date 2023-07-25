<?php

namespace App\Profile\Domains\Repositories;

use App\Profile\Domains\Entities\Stories;
use App\Profile\Domains\Entities\StoryLists;
use App\Review\Domain\Entities\Review;

class GetStoryListRepository
{
  public function store($id)
  {
    $storyList = StoryLists::where('user_id', $id)->get();
    foreach ($storyList as $list) {
      $firstReviewId = Stories::where('story_list_id', $list->id)->first();
      // 여기 나중에 리뷰 이미지 테이블 이용해서 불러오도록 바꿔야함.
      $reviewImage = Review::where('id', $firstReviewId->review_id)
        ->select('review_image')
        ->first();
      $list->image = $reviewImage->review_image;
    }
    return $storyList;
  }
}

?>
