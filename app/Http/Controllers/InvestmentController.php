<?php

namespace App\Http\Controllers;

use App\Binary;
use App\Model\Bonus;
use App\Model\Investment;
use App\Model\VocerPoint;
use App\Model\Deposit;
use App\User;
use Auth;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listInvestment = Auth::user()->rule == 0 ? Investment::all() : Investment::where('user', Auth::user()->id)->get();
        $listInvestment->map(function ($item) {
            $item->user = User::find($item->user);
            return $item;
        });

        $data = [
            'listInvestment' => $listInvestment,
        ];
        return view('reinvest.index', $data);
    }
}
