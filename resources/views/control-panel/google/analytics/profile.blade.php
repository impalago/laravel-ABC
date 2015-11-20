@extends('layouts/layout-panel')

@section('left-panel')
    @include('control-panel/google/blocks.left-panel')
@stop

@section('content')

    <div class="container-fluid">
        <div class="row page-header">
            <h1><small><a href="{{ $profile->getWebsiteUrl() }}" target="_blank">{{  $profile->getWebsiteUrl() }}</a></small></h1>
        </div>
    </div>

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">Select the period</h3>
        </div>
        <div class="panel-body">
            <div class="row select-date">
                {!! Form::open(array('route' => array('ga.statistic', $profile->getId()), 'id' => 'sendData')) !!}
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

    <div class="row generalStatistics">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6 stat-item">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Sessions</h3>
                        </div>
                        <div class="panel-body sessions"></div>
                    </div>
                </div>
                <div class="col-md-6 stat-item">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Pageviews</h3>
                        </div>
                        <div class="panel-body pageviews"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 stat-item">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Avg. Session Duration</h3>
                        </div>
                        <div class="panel-body sessionDuration"></div>
                    </div>
                </div>
                <div class="col-md-6 stat-item">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title ">Users</h3>
                        </div>
                        <div class="panel-body users"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 stat-item">
            <div class="panel panel-info">
                <div class="panel-body">
                    <div id="visitsChart"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div id="chartViews"></div>
        </div>
    </div>


@stop