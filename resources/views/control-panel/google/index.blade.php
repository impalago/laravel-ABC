@extends('layouts/layout-panel')

@section('left-panel')
    @include('control-panel/google/blocks.left-panel')
@stop

@section('content')

    <div class="container-fluid">
        <div class="row page-header">
            <h1>Google</h1>
        </div>
    </div>

    @if($errors->all())
        <div class="alert alert-dismissable alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <ul class="list-group">
                @foreach ($errors->all() as $error)
                    <li class="list-group-item">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

@stop