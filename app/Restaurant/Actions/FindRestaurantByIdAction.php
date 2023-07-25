<?php

namespace App\Restaurant\Actions;

use App\Restaurant\Domain\Repositories\RestaurantRepositoryInterface;

/**
 * 식당 아이디로 식당 정보 조회 액션
 */
class FindRestaurantByIdAction
{
    /**
     * RestaurantRepositoryInterface 저장소 인스턴스
     */
    public function __construct(RestaurantRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 인자로 받은 식당 아이디로 식당 정보를 찾고 반환하는 메서드
     */
    public function __invoke(string $id)
    {
        return $this->repository->find($id);
    }
}
