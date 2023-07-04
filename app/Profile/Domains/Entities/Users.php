<?php

namespace App\Profile\Domains\Entities;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
  protected $table = 'users';

  protected $fillable = ['id', 'nickname', 'profile_image'];
}

?>
