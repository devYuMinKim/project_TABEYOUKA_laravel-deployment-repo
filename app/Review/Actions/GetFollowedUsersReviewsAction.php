<?php

namespace App\Review\Actions;

use App\Review\Domain\Repositories\FollowRepository;
use App\Review\Domain\Review;
use App\Review\Responders\GetFollowedUsersReviewsResponder;

class GetFollowedUsersReviewsAction
{
  protected $followRepository;
  protected $reviewDomain;
  protected $responder;

  public function __construct(FollowRepository $followRepository, Review $reviewDomain, GetFollowedUsersReviewsResponder $responder)
  {
    $this->followRepository = $followRepository;
    $this->reviewDomain = $reviewDomain;
    $this->responder = $responder;
  }

  public function __invoke(string $fromUserId)
  {
    $follows = $this->followRepository->findByFromUser($fromUserId);

    $followedUserIds = [];
    foreach ($follows as $follow) {
        $followedUserIds[] = $follow->getToUser();
    }

    $reviews = $this->reviewDomain->getReviewsByUserIds($followedUserIds);

    $reviewsCount = ceil($reviews->count() / 10);

    $randomReviews = $this->reviewDomain->getRandomReviews($reviewsCount);

    $concatenatedReviews = $reviews->concat($randomReviews);

    return $this->responder->respond($concatenatedReviews);
  }
}
