@extends('layouts/layout-panel')

@section('left-panel')
    @include('control-panel/google/blocks.left-panel')
@stop

@section('content')

    <div class="container-fluid">
        <div class="row page-header">
            <h1>Statistics Profile <small><a href="{{ $profile->getWebsiteUrl() }}" target="_blank">{{ str_replace('http://', '', $profile->getWebsiteUrl()) }}</a></small></h1>
        </div>
    </div>

@stop