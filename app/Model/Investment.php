<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    protected $fillable = [
        'reinvest',
        'join',
        'package',
        'profit',
        'status',
    ];



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id', 'user'
    ];
}
