<?php

namespace App\Profile\Domains\Entities;

use Illuminate\Database\Eloquent\Model;

class StoryList extends Model
{
  protected $table = 'story_lists';

  protected $fillable = ['id', 'user_id', 'story_name'];
}

?>
