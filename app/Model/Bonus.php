<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    protected $fillable = [
        'user',
        'invest_id',
        'description',
        'debit',
        'credit',
        'status',
    ];
}
