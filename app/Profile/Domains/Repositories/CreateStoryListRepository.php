<?php

namespace App\Profile\Domains\Repositories;

use App\Profile\Domains\Entities\StoryList;
use App\Profile\Domains\Entities\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreateStoryListRepository
{
  // 새로운 리뷰 리스트 생성
  public function create($data)
  {
    try {
      User::findOrFail($data->user_id);
    } catch (ModelNotFoundException $e) {
      $errMsg = $e->getMessage();
      return response()->json(['error' => $errMsg]);
    }

    $storyList = StoryList::create([
      'user_id' => $data->user_id,
      'story_name' => $data->story_name,
    ]);

    $reviewList = $data->review_list;

    // pivotテーブルに値を追加
    $storyList->reviews()->attach($reviewList);

    return $storyList;
  }
}

?>
