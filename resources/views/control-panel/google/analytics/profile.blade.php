@extends('layouts/layout-panel')

@section('left-panel')
    @include('control-panel/google/blocks.left-panel')
@stop

@section('content')

    <div class="container-fluid">
        <div class="row page-header">
            <h1>Statistics profile <small><a href="{{ $profile->getWebsiteUrl() }}" target="_blank">{{ str_replace('http://', '', $profile->getWebsiteUrl()) }}</a></small></h1>
        </div>
    </div>

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">Select the period</h3>
        </div>
        <div class="panel-body">
            <div class="row select-date">
                {!! Form::open(array('route' => 'ga.statistic', 'id' => 'sendData')) !!}
                    <div class='col-md-3'>
                        <div class="form-group">
                            <div class='input-group date' id='startDateCont'>
                                {!! Form::text('startDate', null, array('class' => 'form-control', 'id' => 'startDate', 'required' => 'required')) !!}
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class='col-md-3'>
                        <div class="form-group">
                            <div class='input-group date' id='endDateCont'>
                                {!! Form::text('endDate', null, array('class' => 'form-control', 'id' => 'endDate', 'required' => 'required')) !!}
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class='col-md-3'>
                        <div class="form-group">
                            {!! Form::submit('SHOW STATISTIC',array('class' => 'btn btn-primary btn-raised')) !!}
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@stop