<?php

namespace App\Review\Domain\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Profile\Domains\Entities\Users;
use App\Restaurant\Domain\Entities\Restaurant;

class Review extends Model
{
  use HasFactory;

  protected $table = 'reviews';
  protected $primaryKey = 'id';
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

  public function users()
  {
    return $this->belongsTo(Users::class);
  }

  public function restaurants()
  {
    return $this->belongsTo(Restaurant::class);
  }
}
