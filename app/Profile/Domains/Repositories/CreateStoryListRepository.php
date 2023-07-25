<?php

namespace App\Profile\Domains\Repositories;

use App\Profile\Domains\Entities\Stories;
use App\Profile\Domains\Entities\StoryLists;
use App\Profile\Domains\Entities\Users;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreateStoryListRepository
{
  public function create($data)
  {
    try {
      Users::findOrFail($data->user_id);
    } catch (ModelNotFoundException $e) {
      $errMsg = $e->getMessage();
      return response()->json(['error' => $errMsg]);
    }

    $result = StoryLists::create([
      'user_id' => $data->user_id,
      'story_name' => $data->story_name,
    ]);

    $reviewList = $data->review_list;

    // Stories에 추가
    foreach($reviewList as $review) {
      Stories::create([
        'story_list_id' => $result->id,
        'review_id' => $review,
      ]);
    }

    return $result;
  }
}

?>
