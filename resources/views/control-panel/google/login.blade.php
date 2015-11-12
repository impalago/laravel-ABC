@extends('layouts/layout-panel')

@section('left-panel')
    @include('control-panel/google/blocks.left-panel')
@stop

@section('content')

    <div class="row login">
        <div class="alert alert-warning text-center">
            <h2>You need to authorize access before proceeding.</h2>
            <div>
                <a class="btn btn-social btn-google btn-lg" href="{{ $loginUrl }}">
                    <span class="fa fa-google "></span> Sign in with Google
                </a>
            </div>
        </div>
    </div>

@stop