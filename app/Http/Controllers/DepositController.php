<?php

namespace App\Http\Controllers;

use App\Model\Deposit;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Mail;

class DepositController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deposit = Deposit::where('user', Auth::user()->id)->orderBy('id', 'desc')->get();
        $deposit->map(function ($item) {
            $item->user = User::find($item->user);
        });

        $data = [
            'deposit' => $deposit,
        ];

        return view('deposit.index', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $deposit = Deposit::find($id);
        $deposit->description = 'Deposit Tervalidasi';
        $deposit->credit -= $deposit->debit;
        $deposit->debit = 0;
        $deposit->status = 1;

        $user = User::find($deposit->user);
        $data = [
            'user' => $user,
            'nominal' => $deposit->credit,
            'status' => 1,
        ];
        Mail::send('mail.depositMassage', $data, function ($message) use ($user) {
            $message->to($user->email, 'Penerimaan Deposit')->subject('Deposit Anda Telah di Terima');
            $message->from('admin@fkpn.com', 'FKPN');
        });
        $deposit->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deposit = Deposit::find($id);
        $user = User::find($deposit->user);
        $data = [
            'user' => $user,
            'nominal' => $deposit->credit,
            'status' => 2,
        ];
        Mail::send('mail.depositMassage', $data, function ($message) use ($user) {
            $message->to($user->email, 'Pembatalan Deposit')->subject('Deposit Anda Telah di batlkan');
            $message->from('admin@fkpn.com', 'FKPN');
        });
        Deposit::destroy($id);
        return redirect()->back();
    }
}
