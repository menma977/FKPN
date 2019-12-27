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
                            <th class="text-center">join</th>
                            <th class="text-center">package</th>
                            <th class="text-center">profit</th>
                            <th class="text-center">status</th>
                            <th class="text-center">action</th>
                        </thead>
                        <tbody>
                            @foreach ($listInvestment as $item)
                            <tr>
                                <td class="text-center">{{ $item->user->username }}</td>
                                <td class="text-center">Rp {{ number_format($item->join,0,',','.') }}</td>
                                <td class="text-center">Rp {{ number_format($item->package,0,',','.') }}</td>
                                <td class="text-center">Rp {{ number_format($item->profit,0,',','.') }}</td>
                                <td class="text-center">{{ $item->status }}</td>
                                <td class="row text-center">
                                    @if ($item->status == 2)
                                    <div class="col-md-12">
                                        <div class="btn btn-block btn-success">Telah Tervalidasi</div>
                                    </div>
                                    @elseif($item->status == 1)
                                    <div class="col-md-12">
                                        <div class="btn btn-block btn-info">Lunas</div>
                                    </div>
                                    @else
                                    <div class="col-md-6">
                                        <a href="{{ route('Investment.update', [$item->id, 1]) }}"
                                            class="btn btn-block btn-success">
                                            Trima
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="{{ route('Investment.update', [$item->id, 2]) }}"
                                            class="btn btn-block btn-danger">
                                            Batalkan
                                        </a>
                                    </div>
                                    @endif
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
