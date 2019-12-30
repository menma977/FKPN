<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Artisan;

class CronJobController extends Controller
{
    public function run()
    {
        Artisan::call('schedule:run');

        $data = [
            'response' => Artisan::output(),
        ];
        return response()->json($data, 200);
    }
}
