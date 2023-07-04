<?php

namespace App\Search\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

class RestaurantEntity extends Model
{
    protected $table = 'restaurants';
    protected $primaryKey = 'id';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'score'
    ];

    protected $casts = [
        'score' => 'integer',
    ];
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
