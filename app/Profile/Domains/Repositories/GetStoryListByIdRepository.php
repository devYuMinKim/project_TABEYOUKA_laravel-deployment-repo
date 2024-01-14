<?php

namespace App\Profile\Domains\Repositories;

use App\Profile\Domains\Entities\StoryList;
use App\Restaurant\Actions\FindRestaurantByIdAction;

class GetStoryListByIdRepository
{
  public function __construct(protected FindRestaurantByIdAction $findRestaurantByIdAction) {
  }
  public function store($id)
  {
    // 파라미터로 받은 스토리 아이디를 통해 스토리 리스트의 리뷰들을 불러옴
    $storyList = StoryList::with('reviews')->where('id', $id)->first();
    foreach($storyList->reviews as $review) {
      $review->restaurant_name = $this->findRestaurantByIdAction->__invoke($review->restaurant_id)['shop'][0]['name'];
    }
    return $storyList;
  }

}

?>
