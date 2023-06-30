<?php

namespace App\Restaurant\Responders;

/**
 * 식당 아이디로 식당 정보 찾기 응답자 클래스
 */
class FindRestaurantByIdResponder
{
    /**
     * restaurant 데이터를 json 형태로 반환하는 메서드
     */
    public function __invoke($restaurant)
    {
        return response()->json($restaurant);
    }
}
