<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Review;
use App\Models\User;

class Like extends Model
{
  use HasFactory;

  protected $table = 'likes';

  protected $fillable = ['review_id', 'user_id', 'created_at', 'updated_at'];

  public function review()
  {
    return $this->belongsTo(Review::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
