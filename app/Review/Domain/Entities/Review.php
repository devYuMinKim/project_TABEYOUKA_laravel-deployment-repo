<?php

namespace App\Review\Domain\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Profile\Domains\Users;
use App\Restaurant\Domain\Restaurant;

class Review extends Model
{
  use HasFactory;

  protected $table = 'reviews';
  protected $fillable = [
    'id',
    'content',
    'review_image',
    'score',
    'like',
    'restaurant_id',
    'user_id',
    'created_at',
    'updated_at',
  ];

  public function user()
  {
    return $this->belongsTo(Users::class);
  }

  public function restaurant()
  {
    return $this->belongsTo(Restaurant::class);
  }
}
