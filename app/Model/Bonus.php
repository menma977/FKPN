<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    protected $fillable = [
        'user',
        'investment_id',
        'description',
        'debit',
        'credit',
    ];
}
