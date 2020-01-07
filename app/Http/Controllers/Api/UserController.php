<?php

namespace App\Http\Controllers\Api;

use App\Binary;
use App\Http\Controllers\Controller;
use App\Model\Bonus;
use App\Model\Deposit;
use App\Model\Investment;
use App\Model\Ticket;
use App\Model\VocerPoint;
use App\User;
use File;
use Hash;
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
            $token = Auth::user()->tokens;
            foreach ($token as $key => $value) {
                $value->revoke();
                $value->save();
            }
            $user = Auth::user();
            $user->token = $user->createToken('App')->accessToken;
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

    public function logout()
    {
        $token = Auth::user()->tokens;
        foreach ($token as $key => $value) {
            $value->revoke();
            $value->save();
        }
        return response()->json([
            'response' => 'Successfully logged out',
        ], 200);
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
            'password_x' => 'required|min:6',
            'c_password_x' => 'required|same:password_x',
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
                'errors' => [
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
        $user->password_x = bcrypt($request->password_x);
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

        $checkReinvest = Investment::where('user', Auth::user()->id)->orderBy('reinvest', 'desc')->first();
        $vocerPoint = new VocerPoint();
        $vocerPoint->user = Auth::user()->id;
        $vocerPoint->bonus_id = $checkReinvest->id;
        $vocerPoint->description = "Bonus Afiliasi " . number_format($checkReinvest->package * 0.15, 0, ',', '.');
        $vocerPoint->debit = $checkReinvest->package * 0.15;
        $vocerPoint->status = 1;
        $vocerPoint->save();

        $user->token = $user->createToken('App')->accessToken;

        return response()->json(['response' => $user->token], 200);
    }

    public function show()
    {
        return response()->json(['response' => Auth::user()], 200);
    }

    public function update(Request $request)
    {
        if (Hash::check($request->password, Auth::user()->password)) {
            $this->validate($request, [
                'password' => 'required',
                'new_password' => 'required|min:6',
                'new_c_password' => 'required|same:new_password',
            ]);

            $user = Auth::user();
            $user->password = bcrypt($request->new_password);
            $user->save();

            $data = [
                'response' => 'Password anda saat ini adalah: ' . $request->new_password,
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'The given data was invalid.',
                'errors' => [
                    'password' => ['Password lama anda tidak cocok'],
                ],
            ];
            return response()->json($data, 422);
        }
    }

    public function balance()
    {
        $bonus = Bonus::where('user', Auth::user()->id)->sum('credit') - Bonus::where('user', Auth::user()->id)->sum('debit');
        $vocerPoint = VocerPoint::where('user', Auth::user()->id)->sum('credit') - VocerPoint::where('user', Auth::user()->id)->sum('debit');
        $ticket = Ticket::where('user', Auth::user()->id)->sum('credit') - Ticket::where('user', Auth::user()->id)->sum('debit');
        $countInvestment = Investment::where('user', Auth::user()->id)->sum('package') - Investment::where('user', Auth::user()->id)->sum('profit');
        $deposit = Deposit::where('user', Auth::user()->id)->where('status', '!=', 0)->sum('credit') - Deposit::where('user', Auth::user()->id)->where('status', '!=', 0)->sum('debit');

        $data = [
            'bonus' => 'Rp ' . number_format($bonus, 0, ',', '.'),
            'vocerPoint' => 'Rp ' . number_format($vocerPoint, 0, ',', '.'),
            'ticket' => $ticket,
            'countInvestment' => 'Rp ' . number_format($countInvestment, 0, ',', '.'),
            'deposit' => 'Rp ' . number_format($deposit, 0, ',', '.'),
        ];
        return response()->json($data, 200);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'image' => 'required|mimes:jpeg,png,jpg',
        ]);
        // if ($user->image) {
        //     $fileName = explode("/", $user->image);
        //     File::delete($request->root() . '/images' . '/' . $fileName[end($fileName)]);
        // }
        $imageName = time() . '.' . $request->image->extension();

        $request->image->move("images", $imageName);
        $user->image = $request->root() . '/images' . '/' . $imageName;
        $user->save();
        return response()->json(['response' => $user->image], 200);
    }

    public function updateData(Request $request)
    {
        $user = Auth::user();
        if ($request->name) {
            $this->validate($request, [
                'name' => 'required|string',
            ]);
            $user->name = $request->name;
        }
        if ($request->province) {
            $this->validate($request, [
                'province' => 'required|string',
            ]);
            $user->province = $request->province;
        }
        if ($request->district) {
            $this->validate($request, [
                'district' => 'required|string',
            ]);
            $user->district = $request->district;
        }
        if ($request->sub_district) {
            $this->validate($request, [
                'sub_district' => 'required|string',
            ]);
            $user->sub_district = $request->sub_district;
        }
        if ($request->village) {
            $this->validate($request, [
                'village' => 'required|string',
            ]);
            $user->village = $request->village;
        }
        if ($request->number_address) {
            $this->validate($request, [
                'number_address' => 'required|string',
            ]);
            $user->number_address = $request->number_address;
        }
        if ($request->description_address) {
            $this->validate($request, [
                'description_address' => 'required|string|min:10',
            ]);
            $user->description_address = $request->description_address;
        }
        $user->save();
        return response()->json(['response' => 'Data telah di update'], 200);
    }
}
