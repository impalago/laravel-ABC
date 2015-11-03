@extends('layouts.layout-panel')

@section('left-panel')
    @include('control-panel/facebook/blocks.left-panel')
@stop

@section('content')

    <div class="container-fluid">

        <div class="row page-header">
            <div class="col-md-9">
                <h1>{{ isset($page_name) ? $page_name : 'Facebook Page' }}</h1>
            </div>
            <div class="col-md-3 text-right">
                <a class="btn btn-success add-user" href="#" data-toggle="modal" data-target="#addPost"><i class="mdi-content-add-circle-outline"></i> Create Post</a>
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

        @if(isset($posts))
            <div class="posts-list">
                @foreach($posts as $post)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-8">Author: {{ $post['from'] }}</div>
                                <div class="col-md-4 text-right">{{ $post['created_time'] }}</div>
                            </div>
                        </div>
                        <div class="panel-body">
                            @if(isset($post['files']))

                                <div class="col-md-7">{{ $post['message'] }}</div>
                                <div class="col-md-5">
                                    @foreach($post['files'] as $file)
                                        <div class="col-md-6">
                                            <a href="{{ $file['media']['image']['src'] }}" class="thumbnail">
                                                <img src="{{ $file['media']['image']['src'] }}" alt="">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                               {{ $post['message'] }}
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Modal -->
        <div class="modal fade" id="addPost" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                {!! Form::open(array('route' => 'fb.create-post-page', 'files'=>true)) !!}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Create post</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            {!! Form::label('message', 'Message') !!}
                            {!! Form::textarea('message', null, array('class' => 'form-control', 'required')) !!}
                            {!! Form::hidden('page_id', $page_id) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('image', 'Image') !!}
                            {!! Form::file('image') !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        {!! Form::submit('Save', array('class' => 'btn btn-primary')) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>

    </div>

@stop