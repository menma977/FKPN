@extends('layouts.appMobile')

@section('content')
<div class="table-responsive" style="width: 100%;min-width: 1000px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-2">
                <div class="card">
                    <div class="card-header">{{ Auth::user()->name }}</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                name :
                            </div>
                            <div class="col-md-6">
                                {{ Auth::user()->name }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                username :
                            </div>
                            <div class="col-md-6">
                                {{ Auth::user()->username }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row justify-content-center">
            <div class="col-2">
                @if ($binaryLeft)
                <div class="card">
                    <div class="card-header">{{ $binaryLeft ? $binaryLeft->data->name : 'Belum Di Pakai' }}</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                name :
                            </div>
                            <div class="col-md-6">
                                {{ $binaryLeft->data->name }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                username :
                            </div>
                            <div class="col-md-6">
                                {{ $binaryLeft->data->username }}
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="card">
                    <div class="card-header">Belum Di Pakai</div>
                    <div class="card-body">
                        You are logged in!
                    </div>
                </div>
                @endif
            </div>
            <div class="col-2"></div>
            <div class="col-2">
                @if ($binaryRight)
                <div class="card">
                    <div class="card-header">{{ $binaryRight ? $binaryRight->data->name : 'Belum Di Pakai' }}</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                name :
                            </div>
                            <div class="col-md-6">
                                {{ $binaryRight->data->name }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                username :
                            </div>
                            <div class="col-md-6">
                                {{ $binaryRight->data->username }}
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="card">
                    <div class="card-header">Belum Di Pakai</div>
                    <div class="card-body">
                        You are logged in!
                    </div>
                </div>
                @endif
            </div>
        </div>
        <br>
        <div class="row justify-content-center">
            <div class="col-2">
                <div class="card">
                    @if ($binaryLeft)
                    <div class="card-header">{{ $binaryLeft->left ? $binaryLeft->left->data->name : 'Belum Di Pakai' }}
                    </div>
                    <div class="card-body">
                        You are logged in!
                    </div>
                    @else
                    <div class="card-header">Belum Di Pakai</div>
                    <div class="card-body">
                        You are logged in!
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-2">
                <div class="card">
                    @if ($binaryLeft)
                    <div class="card-header">
                        {{ $binaryLeft->right ? $binaryLeft->right->data->name : 'Belum Di Pakai' }}</div>
                    <div class="card-body">
                        You are logged in!
                    </div>
                    @else
                    <div class="card-header">Belum Di Pakai</div>
                    <div class="card-body">
                        You are logged in!
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-2"></div>
            <div class="col-2">
                <div class="card">
                    @if ($binaryRight)
                    <div class="card-header">
                        {{ $binaryRight->left ? $binaryRight->left->data->name : 'Belum Di Pakai' }}</div>
                    <div class="card-body">
                        You are logged in!
                    </div>
                    @else
                    <div class="card-header">Belum Di Pakai</div>
                    <div class="card-body">
                        You are logged in!
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-2">
                <div class="card">
                    @if ($binaryRight)
                    <div class="card-header">
                        {{ $binaryRight->right ? $binaryRight->right->data->name : 'Belum Di Pakai' }}</div>
                    <div class="card-body">
                        You are logged in!
                    </div>
                    @else
                    <div class="card-header">Belum Di Pakai</div>
                    <div class="card-body">
                        You are logged in!
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
