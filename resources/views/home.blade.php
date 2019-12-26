@extends('layouts.app')

@section('content')
<div class="container">
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
