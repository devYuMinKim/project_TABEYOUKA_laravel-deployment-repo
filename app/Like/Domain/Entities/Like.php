<?php

namespace App\Like\Domain\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Review\Domain\Entities\Review;
use App\Profile\Domains\Entities\Users;

class Like extends Model
{
  use HasFactory;

  protected $table = 'likes';
  protected $primaryKey = ['review_id', 'user_id'];
  protected $fillable = ['review_id', 'user_id', 'created_at', 'updated_at'];

  public function review()
  {
    return $this->belongsTo(Review::class);
  }

  public function user()
  {
    return $this->belongsTo(Users::class);
  }
}
