<?php

namespace App\Http\Controllers\Api;

use App\Binary;
use App\Http\Controllers\Controller;
use App\Model\Deposit;
use App\Model\Investment;
use App\Model\VocerPoint;
use Illuminate\Support\Facades\Auth;

class InvestmentController extends Controller
{
    public function index()
    {
        $lastInvest = Investment::where('user', Auth::user()->id)->orderBy('id', 'desc')->first();
        $investList = Investment::where('user', Auth::user()->id)->take(100)->get();
        $investList->map(function ($item) {
            $item->join = "Rp " . number_format($item->join, 0, ',', '.');
            $item->package = "Rp " . number_format($item->package, 0, ',', '.');
            return $item;
        });

        $data = [
            'lastInvest' => $lastInvest,
            'investList' => $investList,
        ];

        return response()->json($data, 200);
    }

    public function create($id)
    {
        if ($id == 1) {
            $package = 500000;
        } else if ($id == 2) {
            $package = 5000000;
        } else if ($id == 3) {
            $package = 1000000;
        } else {
            $package = 10000000;
        }

        $balanceDeposit = Deposit::where('user', Auth::user()->id)->where('status', 1)->sum('credit') - Deposit::where('user', Auth::user()->id)->where('status', 1)->sum('debit');
        if ($balanceDeposit < $package) {
            $data = [
                'message' => 'The given data was invalid.',
                'errors' => [
                    'deposit' => ['Saldo Deposit anda kurang dari Paket yang anda pilih'],
                ],
            ];
            return response()->json($data, 422);
        } else {
            $checkReinvest = Investment::where('user', Auth::user()->id)->orderBy('reinvest', 'desc')->first();
            if ($checkReinvest) {
                $investment = new Investment();
                $investment->reinvest = $checkReinvest->reinvest + 1;
            } else {
                $investment = new Investment();
                $investment->reinvest = 1;
            }
            $investment->user = Auth::user()->id;
            $investment->join = $package;
            $investment->package = $package * 3;
            $investment->status = 2;
            $investment->save();

            $deposit = new Deposit();
            $deposit->user = Auth::user()->id;
            $deposit->credit = 0;
            $deposit->debit = $package;
            $deposit->description = "Investasi sebesar " . number_format($package, 0, ',', '.');
            $deposit->status = 1;
            $deposit->save();

            $binary = Binary::where('user', Auth::user()->id)->first();
            $binary->invest = 0;
            $binary->save();

            VocerPoint::where('user', Auth::user()->id)->delete();

            $vocerPoint = new VocerPoint();
            $vocerPoint->user = Auth::user()->id;
            $vocerPoint->bonus_id = $investment->id;
            $vocerPoint->description = "Reinvest " . number_format($package, 0, ',', '.');
            $vocerPoint->credit = $package * 3;
            $vocerPoint->status = 1;
            $vocerPoint->save();

            return response()->json(['response' => 'Reinvest adan akan di proses dalam waktu kurang dari 2 menit setelah transaksi'], 200);
        }
    }
}
