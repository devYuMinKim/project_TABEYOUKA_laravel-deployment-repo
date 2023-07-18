<?php

namespace App\Review\Domain\Entities;

use App\Review\Domain\Entities\Review;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewImages extends Model
{
  use HasFactory;

  protected $table = 'review_images';
  protected $primaryKey = 'id';
  protected $fillable = [
    'id',
    'review_id',
    'image_url',
    'created_at',
    'updated_at',
  ];

  public function reviews()
  {
    return $this->belongsToMany(Review::class);
  }
}
