<?php

namespace App\Profile\Domains\Repositories;

use App\Profile\Domains\Entities\Story;
use App\Profile\Domains\Entities\StoryList;

class EditStoryListRepository
{
  public function edit($data)
  {
    try {
      StoryList::findOrFail($data->id)->update(['story_name' => $data->story_name]);
    } catch (\Exception $e) {
      $errMsg = $e->getMessage();
      return response()->json(['error' => $errMsg]);
    }

    Story::where('story_list_id' , $data->id)->delete();

    foreach($data->review_list as $reviewId) {
        Story::insert([
          'story_list_id' => $data->id,
          'review_id' => $reviewId,
        ]);
    }
  }
}

?>
