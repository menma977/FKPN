<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Ticket;
use App\User;
use Auth;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $ticket = Ticket::where('user', Auth::user()->id)->get();
        if ($ticket->count()) {
            $data = [
                'response' => $ticket,
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'The given data was invalid.',
                'errors' => [
                    'ticket' => ["Anda tidak memiliki ticket"],
                ],
            ];
            return response()->json($data, 422);
        }
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string|min:1|exists:users,username',
            'count' => 'required|numeric|min:1',
        ]);

        $sumTicket = Ticket::where('user', Auth::user()->id)->sum('credit') - Ticket::where('user', Auth::user()->id)->sum('debit');
        if ($sumTicket > $request->count) {
            $sendUser = User::where('username', $request->username)->first();
            $mainTicket = new Ticket();
            $mainTicket->user = Auth::user()->id;
            $mainTicket->description = "Anda mengirim Tiket sejumlah: " . $request->count . " ke pada: " . $sendUser->username;
            $mainTicket->debit = $request->count;
            $mainTicket->save();

            $sendTicket = new Ticket();
            $sendTicket->user = $sendUser->id;
            $sendTicket->description = Auth::user()->username . " mengirim Tiket sejumlah: " . $request->count . " ke pada: " . $sendUser->username;
            $sendTicket->credit = $request->count;
            $sendTicket->save();

            $data = [
                'response' => $sendTicket->description,
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'The given data was invalid.',
                'errors' => [
                    'ticket' => ['tiket kurang dari jumlah yang di minta. Jumlah tiket anda: ' . $sumTicket],
                ],
            ];
            return response()->json($data, 422);
        }
    }
}
