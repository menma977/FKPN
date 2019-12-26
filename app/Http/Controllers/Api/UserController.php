<?php

namespace App\Http\Controllers\Api;

use App\Binary;
use App\Http\Controllers\Controller;
use App\Model\Ticket;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        if (Auth::attempt(['username' => request('username'), 'password' => request('password')])) {
            $user = Auth::user();
            $user->token = $user->createToken('nApp')->accessToken;
            return response()->json(['response' => $user], 200);
        } else {
            return response()->json(['response' => 'Username atau Password Salah'], 422);
        }
    }

    public function register(Request $request)
    {

        //ToDo:add image| in: ktp_img, ktp_img_user, image
        $this->validate($request, [
            'sponsor' => 'exists:users,username',
            'name' => 'required',
            'username' => 'required|string|min:6|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'c_password' => 'required|same:password',
            'ktp_img' => 'required|max:2048',
            'ktp_img_user' => 'required|max:2048',
            'ktp_number' => 'required|unique:users|numeric',
            'phone' => 'required|unique:users|numeric|digits_between:10,15',
            'image' => 'required|max:2048',
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
            return response()->json(['message' => 'The given data was invalid.', 'error' => ['ticket' => 'seponsor tidak memiliki tiket tersisa']], 422);
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
        $user->save();

        $getSponsor = User::where('username', $request->sponsor)->first();
        $sponsorID = $getSponsor->id;
        $data = null;
        while (true) {
            $binary = Binary::where('sponsor', $sponsorID)->where('position', $request->position)->first();
            if ($binary) {
                $sponsorID = $binary->user;
            } else {
                break;
            }
        }

        $binary = new Binary();
        $binary->sponsor = $sponsorID;
        $binary->user = $user->id;
        $binary->position = $request->position;
        $binary->save();

        $ticket = new Ticket();
        $ticket->description = '1 Tiket telah di pakai oleh: ' . $user->username;
        $ticket->user = $sponsorID;
        $ticket->debit = 1;
        $ticket->type = 1;
        $ticket->save();

        $user->token = $user->createToken('nApp')->accessToken;

        return response()->json(['response' => $user], 200);
    }

    public function show()
    {
        return response()->json(['response' => Auth::user()], 200);
    }
}
