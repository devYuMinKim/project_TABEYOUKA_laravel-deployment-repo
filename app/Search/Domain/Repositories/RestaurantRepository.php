<?php

namespace App\Search\Domain\Repositories;

use App\Search\Domain\Entities\RestaurantEntity;

class RestaurantRepository
{
  public function searchByLocationAndGenre(string $location, string $genre)
  {
    return RestaurantEntity::where('location', $location)->where('genre', $genre)->get();
  }

  public function findNearby(float $latitude, float $longitude, float $range)
  {
    return RestaurantEntity::whereBetween('latitude', [$latitude - $range, $latitude + $range])
          ->whereBetween('longitude', [$longitude - $range, $longitude + $range])
          ->get();
  }
}
