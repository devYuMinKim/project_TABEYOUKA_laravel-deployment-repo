<?php

namespace App\Review\Domain\Entities;

use App\Profile\Domains\Entities\StoryList;
use App\Profile\Domains\Entities\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Restaurant\Domain\Entities\Restaurant;

class Review extends Model
{
  use HasFactory;

  protected $table = 'reviews';
  protected $primaryKey = 'id';
  protected $with = ['reviewImages'];
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
    return $this->belongsTo(User::class);
  }

  public function restaurants()
  {
    return $this->belongsTo(Restaurant::class, 'restaurant_id');
  }

  public function storyLists() {
    return $this->belongsToMany(StoryList::class);
  }

  public function reviewImages() {
    return $this->hasMany(ReviewImages::class);
  }
}
