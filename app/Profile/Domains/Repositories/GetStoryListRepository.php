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
    foreach($storyList as $list) {
      $firstReviewId = Stories::where('story_list_id', $list->id)->first();
      $reviewImage = Review::where('id',$firstReviewId->review_id)->select('review_image')->first();
      $list->image = $reviewImage->review_image;
    }
    return $storyList;
  }
}

?>
