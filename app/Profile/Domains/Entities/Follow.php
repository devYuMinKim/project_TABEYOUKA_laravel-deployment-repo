<?php

namespace App\Profile\Domains\Entities;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
  protected $table = 'follows';

  protected $fillable = ['from_user', 'to_user'];
}

?>
