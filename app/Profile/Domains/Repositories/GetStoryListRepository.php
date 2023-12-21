<?php

namespace App\Profile\Domains\Repositories;

use App\Profile\Domains\Entities\StoryList;
use App\Review\Domain\Entities\ReviewImages;

class GetStoryListRepository
{
  public function store($id)
  {
    // 유저의 모든 스토리 리스트를 불러옴
    $storyList = StoryList::where('user_id', $id)->get();
    foreach ($storyList as $list) {
      // 여기 나중에 리뷰 이미지 테이블 이용해서 불러오도록 바꿔야함.
      $reviewImage = ReviewImages::where('id', $list->reviews[0]->id)->value('image_url');
      $list->mainImage = $reviewImage;
      // 리뷰까지 한번에 불러와서, 리뷰는 불러오지 않게 제거
      unset($list->reviews);
    }
    return $storyList;
  }
}

?>
