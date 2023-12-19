<?php

namespace App\Profile\Domains\Repositories;

use App\Profile\Domains\Entities\Story;
use App\Profile\Domains\Entities\StoryList;

class GetStoryListByIdRepository
{
  public function store($id)
  { 
    $storyList = StoryList::where('id', $id)->first();
    $reviewIds = Story::where('story_list_id', $id)->pluck('review_id');
    $storyList->reviews = $reviewIds;

    return $storyList;
  }
}

?>
