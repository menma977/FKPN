<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    protected $fillable = [
        'user',
        'description',
        'invest_id',
        'total',
        'status',
    ];
}
