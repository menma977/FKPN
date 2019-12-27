@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Bonus</div>
                <div class="card-body">
                    Rp {{ number_format($bonus,0,',','.') }}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Vocer Point</div>
                <div class="card-body">
                    Rp {{ number_format($vocerPoint,0,',','.') }}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Total Vocer</div>
                <div class="card-body">
                    Tiket {{ $ticket }}
                </div>
            </div>
        </div>
    </div>
    <br>

    @if (Auth::user()->rule == 1)
    @if ($statusBinary == 2)
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Tagihan</div>
                <div class="card-body">
                    hallo {{ Auth::user()->name }} mohon segera bayarkan
                </div>
            </div>
        </div>
    </div>
    <hr>
    @elseif ($statusBinary == 0)
    <div class="row justify-content-center">
        <div class="col-md-6">
            <a href="{{ route('package', 1) }}" class="btn btn-block btn-info">Rp 500.000</a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('package', 2) }}" class="btn btn-block btn-info">Rp 5.000.000</a>
        </div>
    </div>
    <hr>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <a href="{{ route('package', 3) }}" class="btn btn-block btn-info">Rp 1.000.000</a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('package', 4) }}" class="btn btn-block btn-info">Rp 10.000.000</a>
        </div>
    </div>
    <hr>
    @endif
    @endif

    <div class="row justify-content-center">
        <div class="col-md-2">
            <div class="card">
                <div class="card-header">{{ Auth::user()->name }}</div>
                <div class="card-body">
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row justify-content-center">
        <div class="col-md-2">
            <div class="card">
                <div class="card-header">{{ $binaryLeft ? $binaryLeft->data->name : 'null' }}</div>
                <div class="card-body">
                    You are logged in!
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-2">
            <div class="card">
                <div class="card-header">{{ $binaryRight ? $binaryRight->data->name : 'null' }}</div>
                <div class="card-body">
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row justify-content-center">
        <div class="col-md-2">
            <div class="card">
                @if ($binaryLeft)
                <div class="card-header">{{ $binaryLeft->left ? $binaryLeft->left->data->name : 'null' }}</div>
                <div class="card-body">
                    You are logged in!
                </div>
                @else
                <div class="card-header">null</div>
                <div class="card-body">
                    You are logged in!
                </div>
                @endif
            </div>
        </div>
        <div class="col-md-2">
            <div class="card">
                @if ($binaryLeft)
                <div class="card-header">{{ $binaryLeft->right ? $binaryLeft->right->data->name : 'null' }}</div>
                <div class="card-body">
                    You are logged in!
                </div>
                @else
                <div class="card-header">null</div>
                <div class="card-body">
                    You are logged in!
                </div>
                @endif
            </div>
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-2">
            <div class="card">
                @if ($binaryRight)
                <div class="card-header">{{ $binaryRight->left ? $binaryRight->left->data->name : 'null' }}</div>
                <div class="card-body">
                    You are logged in!
                </div>
                @else
                <div class="card-header">null</div>
                <div class="card-body">
                    You are logged in!
                </div>
                @endif
            </div>
        </div>
        <div class="col-md-2">
            <div class="card">
                @if ($binaryRight)
                <div class="card-header">{{ $binaryRight->right ? $binaryRight->right->data->name : 'null' }}</div>
                <div class="card-body">
                    You are logged in!
                </div>
                @else
                <div class="card-header">null</div>
                <div class="card-body">
                    You are logged in!
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
