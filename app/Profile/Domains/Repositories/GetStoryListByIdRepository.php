<?php

namespace App\Profile\Domains\Repositories;

use App\Profile\Domains\Entities\StoryList;

class GetStoryListByIdRepository
{
  public function store($id)
  {
    // 파라미터로 받은 스토리 아이디를 통해 스토리 리스트의 리뷰들을 불러옴
    $storyList = StoryList::with('reviews')->where('id', $id)->first();
    return $storyList;
  }
}

?>
