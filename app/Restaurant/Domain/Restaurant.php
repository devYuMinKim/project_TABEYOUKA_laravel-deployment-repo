<?php

namespace App\Restaurant\Domain;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Review\Domain\Review;

class Restaurant extends Model
{
  use HasFactory;

  protected $table = 'restaurants';
  protected $fillable = ['id', 'score', 'created_at', 'updated_at'];

  public function reviews()
  {
    return $this->hasMany(Review::class);
  }

  /**
   * Create a restaurant
   */
  public function createRestaurant(array $restaurant)
  {
    $isExist = self::find($restaurant['id']);

    if ($isExist) {
      return response()->json(['message' => '이미 식당이 존재합니다.'], 422);
    }

    $result = self::create($restaurant);

    return $result;
  }
}
