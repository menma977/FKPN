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
}
