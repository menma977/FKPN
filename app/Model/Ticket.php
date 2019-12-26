<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'user',
        'description',
        'debit',
        'credit',
        'type',
    ];
}
