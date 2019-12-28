@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Withdraw List</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th class="text-center">username</th>
                            <th class="text-center">Package ke </th>
                            <th class="text-center">total Withdraw</th>
                            <th class="text-center">status</th>
                            <th class="text-center">action</th>
                        </thead>
                        <tbody>
                            @foreach ($withdraws as $item)
                            <tr>
                                <td class="text-center">
                                    {{ $item->user->username }}
                                </td>
                                <td class="text-center">
                                    {{ $item->invest_id }}
                                </td>
                                <td class="text-center">
                                    Rp {{ number_format($item->total,0,',','.') }}
                                </td>
                                <td class="text-center {{ $item->status == 0 ? 'text-danger' : "text-success" }}">
                                    {{ $item->status == 0 ? "Belum Di Approve" : "Sudah Di Approve" }}
                                </td>
                                <td class="text-center">
                                    @if ($item->status == 1)
                                    <div class="btn btn-block btn-success">
                                        Di Terima
                                    </div>
                                    @elseif($item->status == 2)
                                    <div class="btn btn-block btn-danger">
                                        Di Batalkan
                                    </div>
                                    @else
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a href="{{ route('withdraw.update', $item->id) }}"
                                                class="btn btn-block btn-success">
                                                Terima
                                            </a>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="{{ route('withdraw.delete', $item->id) }}"
                                                class="btn btn-block btn-warning">
                                                Batalkan
                                            </a>
                                        </div>
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
