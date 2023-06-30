<?php

namespace App\Restaurant\Domain\Repositories;

/**
 * 식당 정보를 조회하는 인터페이스
 */
interface RestaurantRepositoryInterface
{
    /**
     * 식당 아이디로 식당 정보 조회 메서드
     */
    public function find(string $id);
}
