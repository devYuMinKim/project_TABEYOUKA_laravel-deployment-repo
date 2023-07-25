<?php

namespace App\Review\Domain\Entities;

class Follow
{
  private $fromUser;
  private $toUser;

  public function __construct(string $fromUser, string $toUser)
  {
    $this->fromUser = $fromUser;
    $this->toUser = $toUser;
  }

  public function getFromUser(): string
  {
    return $this->fromUser;
  }

  public function getToUser(): string
  {
    return $this->toUser;
  }
}