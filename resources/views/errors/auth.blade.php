@extends('layouts.layout-panel')

@section('left-panel')
    @include('layouts/blocks.left-panel')
@stop

@section('content')

    <div class="row login">
        <div class="alert alert-warning text-center">
            <h2>You need to authorize access before proceeding.</h2>
            <div>
                <a class="btn btn-social btn-{{ $provider }} btn-lg" href="{{ route('auth.socialite', $provider) }}">
                    <span class="fa fa-{{ $provider }} "></span> Sign in with {{ $provider }}
                </a>
            </div>
        </div>
    </div>

@stop