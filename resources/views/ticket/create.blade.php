@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Membuat Atau Menambah Tiket</div>

                <form action="{{ route('ticket.store') }}" method="post">
                    @csrf
                    <div class="card-body row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <select class="custom-select @error('username') is-invalid @enderror" id="username"
                                    name="username">
                                    @foreach ($users as $item)
                                    <option value="{{ $item->id }}">{{ $item->username }}</option>
                                    @endforeach
                                </select>
                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="from-group">
                                <label for="ticket">Jumlah Tiket</label>
                                <input type="text" name="ticket" id="ticket"
                                    class="form-control @error('ticket') is-invalid @enderror"
                                    value="{{ old('ticket') }}" required>
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
