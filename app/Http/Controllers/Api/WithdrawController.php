<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Bonus;
use App\Model\Investment;
use App\Model\Withdraw;
use App\User;
use Auth;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    public function create(Request $request)
    {
        $withdrawUserCount = Withdraw::where('user', Auth::user()->id)->where('status', 0)->sum('total');
        $maxWD = Investment::where('user', Auth::user()->id)->orderBy('id', 'desc')->sum('package');
        $this->validate($request, [
            'nominal' => 'required|numeric|max:' . ($maxWD - $withdrawUserCount) . '|min:100000',
        ]);

        $sumBonusUser = Bonus::where('user', Auth::user()->id)->sum('credit') - Bonus::where('user', Auth::user()->id)->sum('debit');
        if ($request->nominal > $sumBonusUser) {
            $data = [
                'message' => 'The given data was invalid.',
                'error' => [
                    'nominal' => [
                        'nominal withdraw melebihi maxsimum bonus anda (' . $sumBonusUser . ')',
                    ],
                ],
            ];
            return response()->json($data, 422);
        }

        $investID = Investment::where('user', Auth::user()->id)->orderBy('id', 'desc')->first()->reinvest;

        $withdraw = new Withdraw();
        $withdraw->user = Auth::user()->id;
        $withdraw->description = "withdraw anda sebesar: Rp " . number_format($request->nominal, 0, ',', '.') . " masih dalam proses admin";
        $withdraw->invest_id = $investID;
        $withdraw->total = $request->nominal;
        $withdraw->status = 0;
        $withdraw->save();

        $data = [
            'response' => 'withdraw anda masuk pada antrian mohon menunggu hingga hari senin untuk di proses admin',
        ];
        return response()->json($data, 200);
    }
}
