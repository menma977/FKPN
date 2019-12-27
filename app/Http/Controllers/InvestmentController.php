<?php

namespace App\Http\Controllers;

use App\Binary;
use App\Model\Bonus;
use App\Model\Investment;
use App\Model\VocerPoint;
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function update($id, $status)
    {
        if ($status == 1) {
            $investment = Investment::find($id);

            $findUpSponsor = Binary::where('user', $investment->user)->first()->sponsor;
            $investmentSponsor = Investment::where('user', $findUpSponsor)->where('status', 2)->orderBy('id', 'desc')->first();
            if ($investmentSponsor) {
                if ($investmentSponsor->package >= ($investmentSponsor->profit + ($investment->join * 0.15))) {
                    $investmentSponsor->profit += ($investment->join * 0.15);
                    $investmentSponsor->status = 2;
                    $investmentSponsor->save();

                    if ($investmentSponsor->package >= $investmentSponsor->profit) {
                        $investmentSponsor->status = 1;
                        $investmentSponsor->save();

                        $binary = Binary::where('user', $investmentSponsor->user)->first();
                        $binary->invest = 0;
                        $binary->save();
                    }
                } else {
                    $investmentSponsor->profit += ($investment->join * 0.15);
                    $investmentSponsor->status = 1;
                    $investmentSponsor->save();

                    $binary = Binary::where('user', $investmentSponsor->user)->first();
                    $binary->invest = 0;
                    $binary->save();
                }
                $bonusSponsor = new Bonus();
                $bonusSponsor->user = $findUpSponsor;
                $bonusSponsor->invest_id = $investmentSponsor->id;
                $bonusSponsor->description = "Bonus Sponsor";
                $bonusSponsor->credit = ($investment->join * 0.15);
                $bonusSponsor->save();

                $vocerPointSponsor = new VocerPoint();
                $vocerPointSponsor->user = $findUpSponsor;
                $vocerPointSponsor->description = "Bonus Sponsor";
                $vocerPointSponsor->bonus_id = $bonusSponsor->id;
                $vocerPointSponsor->debit = ($investment->join * 0.15);
                $vocerPointSponsor->save();
            }

            $vocerPoint = new VocerPoint();
            $vocerPoint->user = $investment->user;
            $vocerPoint->description = "Reinvest Limit";
            $vocerPoint->credit = $investment->package;
            $vocerPoint->save();

            $investment->status = 2;
            $investment->save();
        } else {
            $user = Investment::find($id)->user;
            $binary = Binary::where('user', $user)->first();
            $binary->invest = 0;
            $binary->save();
            Investment::destroy($id);
        }

        return redirect()->back();
    }
}
