<?php

namespace App\Profile\Domains\Entities;

use Illuminate\Database\Eloquent\Model;

class Follows extends Model
{
  protected $table = 'Follows';

  protected $fillable = ['from_user, to_user'];
}

?>
