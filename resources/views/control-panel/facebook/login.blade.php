@extends('layouts/layout-panel')

@section('left-panel')
    @include('control-panel/facebook/blocks.left-panel')
@stop

@section('content')

    <div class="row login">
        <div class="alert alert-warning text-center">
            <h2>You need to authorize access before proceeding.</h2>
            <div>
                <a class="btn btn-primary btn-lg" href="{{ $loginUrl }}">
                    Sign in with Facebook
                </a>
            </div>
        </div>
    </div>

@stop