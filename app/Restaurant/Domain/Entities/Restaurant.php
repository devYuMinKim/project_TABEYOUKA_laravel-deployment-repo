<?php

namespace App\Restaurant\Domain\Entities;

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
}
