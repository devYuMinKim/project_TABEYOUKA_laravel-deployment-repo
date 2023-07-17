<?php

namespace App\Profile\Domains\Repositories;

use App\Profile\Domains\Entities\Stories;
use App\Profile\Domains\Entities\StoryLists;

class GetStoryListByIdRepository
{
  public function store($id)
  { 
    $storyList = StoryLists::where('id', $id)->first();
    $reviewIds = Stories::where('story_list_id', $id)->pluck('review_id');
    $storyList->reviews = $reviewIds;

    return $storyList;
  }
}

?>
