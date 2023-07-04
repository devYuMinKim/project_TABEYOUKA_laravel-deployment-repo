<?php

namespace App\Recommendation\Domain\Entities;

/**
 * 사용자 장르 선호도 클래스
 */
class UserGenrePreference
{
    private $userId;
    private $preferences;

    public function __construct(string $userId, array $preferences)
    {
        $this->userId = $userId;
        $this->preferences = $preferences;
    }

    /**
     * 사용자 ID 반환
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * 사용자 선호 장르 목록 반환
     */
    public function getPreferences(): array
    {
        return $this->preferences;
    }
}
