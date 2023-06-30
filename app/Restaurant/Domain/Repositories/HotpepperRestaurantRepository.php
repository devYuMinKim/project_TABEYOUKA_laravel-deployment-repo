<?php

namespace App\Restaurant\Domain\Repositories;

use App\Services\RecruitApiService;

/**
 * Hotpepper API를 사용하여 식당 정보를 조회하는 클래스
 */
class HotpepperRestaurantRepository implements RestaurantRepositoryInterface
{
    private $recruitApiService;

    /**
     * 생성자에서 RecruitApiService 주입
     */
    public function __construct(RecruitApiService $recruitApiService)
    {
        $this->recruitApiService = $recruitApiService;
    }

    /**
     * 식당 아이디로 식당 정보 찾는 메서드 구현
     */
    public function find(string $id)
    {
        return $this->recruitApiService->getRestaurantById($id);
    }
}
