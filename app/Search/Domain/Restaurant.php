<?php

namespace App\Search\Domain;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
  /**
   * 지역과 음식 장르에 맞는 식당 검색 로직
   * - 입력된 지역과 장르 조건에 대한 결과를 반환함
   */
  public static function searchByLocationAndGenre(string $location, string $genre)
  {
    return self::where('location', $location)->where('genre', $genre)->get();
  }

  /**
   * 주변 식당 검색 로직
   */
  public static function findNearby(float $latitude, float $longitude, float $range)
  {
    return self::whereBetween('latitude', [$latitude - $range, $latitude + $range])
          ->whereBetween('longitude', [$longitude - $range, $longitude + $range])
          ->get();
  }
}