<?php

namespace App\Profile\Domains\Repositories;

use App\Profile\Domains\Entities\Stories;
use App\Profile\Domains\Entities\StoryLists;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EditStoryListRepository
{
  public function edit($data)
  {
    try {
      StoryLists::findOrFail($data->id)->update(['story_name' => $data->story_name]);
    } catch (\Exception $e) {
      $errMsg = $e->getMessage();
      return response()->json(['error' => $errMsg]);
    }

    Stories::where('story_list_id' , $data->id)->delete();

    foreach($data->review_list as $reviewId) {
        Stories::insert([
          'story_list_id' => $data->id,
          'review_id' => $reviewId,
        ]);
    }
  }
}

?>
