<?php

namespace App\Http\Controllers;

use App\Binary;
use App\Model\Bonus;
use App\Model\Investment;
use App\Model\Ticket;
use App\Model\VocerPoint;
use App\User;
use Auth;
use Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $binaryLeft = Binary::where('up_line', Auth::user()->id)->where('position', 0)->first();
        $binaryRight = Binary::where('up_line', Auth::user()->id)->where('position', 1)->first();
        if ($binaryLeft) {
            $binaryLeft->data = User::find($binaryLeft->user);
            $binaryLeft->left = Binary::where('up_line', $binaryLeft->user)->where('position', 0)->first();
            if ($binaryLeft->left) {
                $binaryLeft->left->data = User::find($binaryLeft->left->user);
            }
            $binaryLeft->right = Binary::where('up_line', $binaryLeft->user)->where('position', 1)->first();
            if ($binaryLeft->right) {
                $binaryLeft->right->data = User::find($binaryLeft->right->user);
            }
        }
        if ($binaryRight) {
            $binaryRight->data = User::find($binaryRight->user);
            $binaryRight->left = Binary::where('up_line', $binaryRight->user)->where('position', 0)->first();
            if ($binaryRight->left) {
                $binaryRight->left->data = User::find($binaryRight->left->user);
            }
            $binaryRight->right = Binary::where('up_line', $binaryRight->user)->where('position', 1)->first();
            if ($binaryRight->right) {
                $binaryRight->right->data = User::find($binaryRight->right->user);
            }
        }

        $statusBinary = Binary::where('user', Auth::user()->id)->whereIn('invest', [0, 1, 2])->first();
        if ($statusBinary) {
            $status = $statusBinary->invest;
        } else {
            $status = 0;
        }

        $bonus = Bonus::where('user', Auth::user()->id)->sum('credit') - Bonus::where('user', Auth::user()->id)->sum('debit');
        $vocerPoint = VocerPoint::where('user', Auth::user()->id)->sum('credit') - VocerPoint::where('user', Auth::user()->id)->sum('debit');
        $ticket = Ticket::where('user', Auth::user()->id)->sum('credit') - Ticket::where('user', Auth::user()->id)->sum('debit');

        $data = [
            'binaryLeft' => $binaryLeft,
            'binaryRight' => $binaryRight,

            'statusBinary' => $status,

            'bonus' => $bonus,
            'vocerPoint' => $vocerPoint,
            'ticket' => $ticket,
        ];

        return view('home', $data);
    }

    public function package($id)
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

        $checkReinvest = Investment::where('user', Auth::user()->id)->orderBy('reinvest', 'desc')->first();
        if ($checkReinvest) {
            $investment = new Investment();
            $investment->reinvest = $investment->reinvest + 1;
        } else {
            $investment = new Investment();
            $investment->reinvest = 1;
        }
        $investment->user = Auth::user()->id;
        $investment->join = $package;
        $investment->package = $package * 3;
        $investment->save();

        $binary = Binary::where('user', Auth::user()->id)->first();
        $binary->invest = 1;
        $binary->save();

        $data = [
            'user' => Auth::user(),
            'package' => $package + rand(99, 999),
        ];

        Mail::send('mail.invest', $data, function ($message) {
            $message->to(Auth::user()->email, 'Selesaikan Transaksi')->subject('Selesaikan Transaksi pembayaran');
            $message->from('admin@fkpn.com', 'FKPN');
        });

        return redirect()->back();
    }
}
