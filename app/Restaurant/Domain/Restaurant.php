<?php

namespace App\Restaurant\Domain;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\RestaurantAlreadyExistsException;
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
      throw new RestaurantAlreadyExistsException();
    }

    $result = self::create([...$restaurant, 'score' => 0]);

    return $result;
  }
}
