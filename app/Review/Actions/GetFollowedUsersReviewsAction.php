<?php

namespace App\Review\Actions;

use App\Review\Domain\Repositories\FollowRepository;
use App\Review\Domain\Repositories\ReviewRepository as Repository;
use App\Review\Responders\GetFollowedUsersReviewsResponder as Responder;

class GetFollowedUsersReviewsAction
{
  public function __construct(
    protected FollowRepository $followRepository,
    protected Repository $repository,
    protected Responder $responder
  ) {
  }

  public function __invoke(string $fromUserId)
  {
    $follows = $this->followRepository->findByFromUser($fromUserId);

    $followedUserIds = [];
    foreach ($follows as $follow) {
      $followedUserIds[] = $follow->getToUser();
    }

    $reviews = $this->repository->getReviewsByUserIds($followedUserIds);

    $reviewsCount = ceil($reviews->count() / 10);

    $randomReviews = $this->repository->getRandomReviews($reviewsCount);

    $concatenatedReviews = $reviews->concat($randomReviews);

    return $this->responder->respond($concatenatedReviews);
  }
}
