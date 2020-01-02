<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\Investment;

class InvestmentController extends Controller
{
    public function index()
    {
        $lastInvest = Investment::where('user', Auth::user()->id)->orderBy('id', 'desc')->first();
        $investList = Investment::where('user', Auth::user()->id)->get();

        $data = [
            'lastInvest' => $lastInvest,
            'investList' => $investList
        ];

        return response()->json($data, 200);
    }
}
