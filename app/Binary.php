<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Binary extends Model
{
    protected $fillable = [
        'sponsor',
        'user',
        'position',
        'invest',
    ];
}
