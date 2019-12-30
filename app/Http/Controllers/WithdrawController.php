<?php

namespace App\Http\Controllers;

use App\Model\Bonus;
use App\Model\Withdraw;
use App\User;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $withdraws = Withdraw::orderBy('id', 'desc')->get();
        $withdraws->map(function ($item) {
            $item->user = User::find($item->user);
        });

        $data = [
            'withdraws' => $withdraws,
        ];
        return view('withdraw.index', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $withdraw = Withdraw::find($id);
        $bonus = new Bonus();
        $bonus->user = $withdraw->user;
        $bonus->invest_id = $withdraw->invest_id;
        $bonus->debit = $withdraw->total;
        $bonus->description = "Withdraw Sejumlah: Rp "
        . number_format($withdraw->total - ($withdraw->total * 0.05), 0, ',', '.')
        . " biyaya Admin: Rp "
        . number_format(($withdraw->total * 0.05), 0, ',', '.');
        $bonus->status = 1;
        $bonus->save();

        $withdraw->description = "Anda Withdraw sejumlah: Rp "
        . number_format($withdraw->total - ($withdraw->total * 0.05), 0, ',', '.')
        . " dan biyaya Admin: Rp "
        . number_format(($withdraw->total * 0.05), 0, ',', '.');
        $withdraw->total = $withdraw->total;
        $withdraw->status = 1;
        $withdraw->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $withdraw = Withdraw::find($id);
        $withdraw->description = "Di batalkan";
        $withdraw->status = 2;
        $withdraw->save();

        return redirect()->back();
    }
}
