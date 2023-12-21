<?php

namespace App\Profile\Domains\Entities;

use App\Review\Domain\Entities\Review;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  use HasFactory;

  protected $table = 'users';
  protected $primaryKey = 'id';
  public $incrementing = false;

  protected $keyType = 'string';

  protected $fillable = ['id', 'nickname', 'profile_image', 'bio'];

  public function reviews() {
    return $this->hasMany(Review::class);
  }
  public function storyLists() {
    return $this->hasMany(StoryList::class);
  }

}

?>
