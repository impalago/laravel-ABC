@extends('layouts.layout-panel')

@section('left-panel')
    @include('layouts/blocks.left-panel')
@stop

@section('content')

    <div class="row login">
        <div class="alert alert-warning text-center">
            <h2>Access denied</h2>
            <div>
                You do not have access to this section!<br>
            </div>
            <br>
        </div>
    </div>

@stop