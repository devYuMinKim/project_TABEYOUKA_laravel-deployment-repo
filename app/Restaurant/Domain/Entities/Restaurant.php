<?php

namespace App\Restaurant\Domain\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Review\Domain\Entities\Review;

class Restaurant extends Model
{
  use HasFactory;

  protected $table = 'restaurants';
  protected $keyType = 'string';

  protected $primaryKey = 'id';
  protected $fillable = ['id', 'score', 'created_at', 'updated_at'];

  public function reviews()
  {
    return $this->hasMany(Review::class);
  }
}
