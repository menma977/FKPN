<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Deposit;
use Auth;
use Illuminate\Http\Request;
use Mail;

class DepositController extends Controller
{
    public function index()
    {
        $deposit = Deposit::where('user', Auth::user()->id)->orderBy('id', 'desc')->take(100)->get();

        $data = [
            'deposit' => $deposit,
        ];

        return response()->json(['response' => $data], 200);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'deposit' => 'required|numeric|min:500000',
        ]);

        $validateDeposit = Deposit::where('user', Auth::user()->id)->where('status', 0)->count();
        if (!$validateDeposit) {
            $codeTransaction = rand(99, 999);
            $deposit = new Deposit();
            $deposit->user = Auth::user()->id;
            $deposit->credit = $request->deposit + $codeTransaction;
            $deposit->debit = $codeTransaction;
            $deposit->description = "Request Deposit";

            $data = [
                'user' => Auth::user(),
                'package' => $deposit->credit,
                'name' => 'aww',
                'bank' => 'aww',
                'accountNumber' => '00000',
            ];

            Mail::send('mail.invest', $data, function ($message) {
                $message->to(Auth::user()->email, 'Selesaikan Transaksi')->subject('Selesaikan Transaksi pembayaran');
                $message->from('admin@fkpn.com', 'FKPN');
            });

            $deposit->save();

            return response()->json(['response' => 'tunggu untuk di validasi oleh admin'], 200);
        } else {
            $data = [
                'message' => 'The given data was invalid.',
                'errors' => [
                    'invest' => ['Tolong lunasi transaksi anda terlebih dahulu sebelum memilih paket baru'],
                ],
            ];
            return response()->json($data, 422);
        }
    }

    public function show()
    {
        $deposit = Deposit::where('user', Auth::user()->id)->where('status', 0)->orderBy('id', 'desc')->first();
        if ($deposit) {
            $data = [
                'userName' => Auth::user()->name,
                'package' => 'Rp ' . number_format($deposit->credit, 0, ',', '.'),
                'name' => 'aww',
                'bank' => 'aww',
                'accountNumber' => '00000',
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Tidak ada tagihan'
            ];
            return response()->json($data, 201);
        }
    }
}
