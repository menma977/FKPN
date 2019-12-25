<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ConfigProfit extends Model
{
    protected $fillable = [
        'roi',
        'roi_max',
        'ticket',
        'sponsor',
        'pairing',
        'reinvest',
        'capping',
    ];
}
