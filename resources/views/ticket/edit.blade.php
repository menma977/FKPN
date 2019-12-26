@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Edit Ticket</div>

                <form action="{{ route('ticket.update', $ticket->id) }}" method="post">
                    @csrf
                    <div class="card-body row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <div class="form-control">{{ $ticket->user->username }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="from-group">
                                <label for="ticket">Jumlah Tiket</label>
                                <input type="text" name="ticket" id="ticket"
                                    class="form-control @error('ticket') is-invalid @enderror"
                                    value="{{ old('ticket') ? old('ticket') : $ticket->credit }}" required>
                                @error('ticket')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
