<?php

namespace App\Profile\Domains\Repositories;

use App\Profile\Domains\Entities\StoryList;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EditStoryListRepository
{
  // 리뷰 리스트 수정
  public function edit($data)
  {
    try {
      $storyList = StoryList::findOrFail($data->id);
    } catch (ModelNotFoundException $e) {
      $errMsg = $e->getMessage();
      return response()->json(['error' => $errMsg]);
    }

    $storyList->update(['story_name' => $data->story_name]);

    $storyList->reviews()->detach();

    $storyList->reviews()->attach($data->review_list);

    return response()->json(['message' => 'Story updated successfully']);
  }
}

?>
