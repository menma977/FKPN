@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">User List</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th class="text-center">username</th>
                            <th class="text-center">description</th>
                            <th class="text-center">debit</th>
                            <th class="text-center">credit</th>
                            <th class="text-center">action</th>
                        </thead>
                        <tbody>
                            @foreach ($ticket as $item)
                            <tr>
                                <td class="text-center">{{ $item->user->username }}</td>
                                <td class="text-center">{{ $item->description }}</td>
                                <td class="text-center">{{ $item->debit }}</td>
                                <td class="text-center">{{ $item->credit }}</td>
                                <td class="row text-center">
                                    <div class="col-md-6">
                                        <a href="{{ route('ticket.edit', $item->id) }}" class="btn btn-block btn-warning">
                                            Edit
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="{{ route('ticket.delete', $item->id) }}"
                                            class="btn btn-block btn-danger">
                                            Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
