<?php

namespace App\Http\Controllers;

use App\Model\Ticket;
use App\User;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ticket = Ticket::orderBy('created_at', 'desc')->get();
        $ticket->map(function ($item) {
            $item->user = User::find($item->user);
        });

        $data = [
            'ticket' => $ticket,
        ];
        return view('ticket.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('rule', 1)->get();
        $users = User::all();
        $data = [
            'users' => $users,
        ];
        return view('ticket.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|exists:users,id',
            'ticket' => 'required|numeric|min:1',
        ]);

        $ticket = new Ticket();
        $ticket->description = "Admin menabah tiket ke pada akun anda sejumlah: " . $request->ticket;
        $ticket->user = $request->username;
        $ticket->credit = $request->ticket;
        $ticket->save();

        return redirect()->route('ticket.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit($ticketID)
    {
        $ticket = Ticket::find($ticketID);
        $ticket->user = User::find($ticket->user);
        $data = [
            'ticket' => $ticket,
        ];
        return view('ticket.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $ticketID)
    {
        $this->validate($request, [
            'ticket' => 'required|numeric|min:1',
        ]);

        $ticket = Ticket::find($ticketID);
        $ticket->description = "Admin Mengubah tiket ke pada akun anda sejumlah: " . $request->ticket;
        $ticket->credit = $request->ticket;
        $ticket->save();

        return redirect()->route('ticket.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy($ticketID)
    {
        Ticket::destroy($ticketID);

        return redirect()->route('ticket.index');
    }
}
