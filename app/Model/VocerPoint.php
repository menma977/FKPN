<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VocerPoint extends Model
{
    protected $fillable = [
        'user',
        'bonus_id',
        'description',
        'debit',
        'credit',
        'status',
    ];
}
