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
                            <th class="text-center">name</th>
                            <th class="text-center">email</th>
                            <th class="text-center">phone</th>
                            <th class="text-center">address</th>
                            <th class="text-center">type User</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">action</th>
                        </thead>
                        <tbody>
                            @foreach ($users as $item)
                            <tr>
                                <td class="text-center">{{ $item->username }}</td>
                                <td class="text-center">{{ $item->name }}</td>
                                <td class="text-center">{{ $item->email }}</td>
                                <td class="text-center">{{ $item->phone }}</td>
                                <td class="text-center">{{ $item->address }}</td>
                                <td class="text-center">{{ $item->rule == 0 ? "admin" : "member" }}</td>
                                <td class="text-center">
                                    @if ($item->status == 1)
                                    <div class="btn btn-success">Active</div>
                                    @else
                                    <div class="btn btn-danger">Non-Active</div>
                                    @endif
                                </td>
                                <td class="row text-center">
                                    <div class="col-md-6">
                                        <a href="{{ route('user.edit', $item->id) }}" class="btn btn-block btn-warning">
                                            Edit
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="{{ route('user.delete', $item->id) }}"
                                            class="btn btn-block btn-danger">
                                            {{ $item->status == 1 ? "Suspan" : "UnSuspan" }}
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
