<?php

namespace App\Profile\Domains\Entities;

use App\Review\Domain\Entities\Review;
use Illuminate\Database\Eloquent\Model;

class StoryList extends Model
{
  protected $table = 'story_lists';

  protected $fillable = ['id', 'user_id', 'story_name'];

  public function user() {
    $this->belongsTo(User::class);
  }

  public function reviews() {
    return $this->belongsToMany(Review::class);
  }
}



?>
