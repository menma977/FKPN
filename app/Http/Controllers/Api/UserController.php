<?php

namespace App\Http\Controllers\Api;

use App\Binary;
use App\Http\Controllers\Controller;
use App\Model\Bonus;
use App\Model\Investment;
use App\Model\Ticket;
use App\Model\VocerPoint;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function verification()
    {
        return response()->json(['response' => Auth::check()], 200);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        if (Auth::attempt(['username' => request('username'), 'password' => request('password')])) {
            $user = Auth::user();
            $user->token = $user->createToken('nApp')->accessToken;
            return response()->json(['response' => $user->token], 200);
        } else {
            $data = [
                'message' => 'The given data was invalid.',
                'errors' => [
                    'validation' => ['username atau password tidak valid.'],
                ],
            ];
            return response()->json($data, 422);
        }
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'sponsor' => 'required|string|exists:users,username',
            'name' => 'required|string',
            'username' => 'required|string|min:6|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'c_password' => 'required|same:password',
            'ktp_number' => 'required|unique:users|numeric',
            'phone' => 'required|unique:users|numeric|digits_between:10,15',
            'province' => 'required|string',
            'district' => 'required|string',
            'sub_district' => 'required|string',
            'village' => 'required|string',
            'number_address' => 'required|string',
            'description_address' => 'required|string|min:10',
        ]);

        $creditTicket = Ticket::where('user', User::where('username', $request->sponsor)->first()->id)->sum('credit');
        $debitTicket = Ticket::where('user', User::where('username', $request->sponsor)->first()->id)->sum('debit');
        if (($creditTicket - $debitTicket) <= 0) {
            $data = [
                'message' => 'The given data was invalid.',
                'error' => [
                    'ticket' => 'seponsor tidak memiliki tiket tersisa',
                ],
            ];
            return response()->json($data, 422);
        }

        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->ktp_img = $request->ktp_img;
        $user->ktp_img_user = $request->ktp_img_user;
        $user->ktp_number = $request->ktp_number;
        $user->phone = $request->phone;
        $user->image = $request->image;
        $user->province = $request->province;
        $user->district = $request->district;
        $user->sub_district = $request->sub_district;
        $user->village = $request->village;
        $user->number_address = $request->number_address;
        $user->description_address = $request->description_address;
        $user->status = 2;
        $user->save();

        $getSponsor = User::where('username', $request->sponsor)->first();
        $sponsorID = $getSponsor->id;
        $data = null;
        while (true) {
            $binary = Binary::where('up_line', $sponsorID)->where('position', $request->position)->first();
            if ($binary) {
                $sponsorID = $binary->user;
            } else {
                break;
            }
        }

        $binary = new Binary();
        $binary->sponsor = $getSponsor->id;
        $binary->up_line = $sponsorID;
        $binary->user = $user->id;
        $binary->position = $request->position;
        $binary->save();

        $ticket = new Ticket();
        $ticket->description = '1 Tiket telah di pakai oleh: ' . $user->username;
        $ticket->user = $getSponsor->id;
        $ticket->debit = 1;
        $ticket->type = 1;
        $ticket->save();

        $user->token = $user->createToken('nApp')->accessToken;

        return response()->json(['response' => $user->token], 200);
    }

    public function show()
    {
        return response()->json(['response' => Auth::user()], 200);
    }

    public function balance()
    {
        $bonus = Bonus::where('user', Auth::user()->id)->sum('credit') - Bonus::where('user', Auth::user()->id)->sum('debit');
        $vocerPoint = VocerPoint::where('user', Auth::user()->id)->sum('credit') - VocerPoint::where('user', Auth::user()->id)->sum('debit');
        $ticket = Ticket::where('user', Auth::user()->id)->sum('credit') - Ticket::where('user', Auth::user()->id)->sum('debit');
        $countInvestment = Investment::where('user', Auth::user()->id)->sum('package') - Investment::where('user', Auth::user()->id)->sum('profit');

        $data = [
            'bonus' => 'Rp ' . number_format($bonus, 0, ',', '.'),
            'vocerPoint' => 'Rp ' . number_format($vocerPoint, 0, ',', '.'),
            'ticket' => $ticket,
            'countInvestment' => 'Rp ' . number_format($countInvestment, 0, ',', '.'),
        ];
        return response()->json($data, 200);
    }
}
