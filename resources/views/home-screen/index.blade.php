@extends('layouts.layout-auth')

@section('content')

    <div class="container home-screen">
        <div class="jumbotron">
            <div class="page-header text-center">
                <h2>Opportunities project</h2>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Google Analytics API</div>
                <div class="panel-body">
                    The module displays a list of projects the logged-on user. For each project there is an opportunity to get statistics for the selected period
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">YouTube API</div>
                <div class="panel-body">
                    The module displays a list of logged-on user subscriptions. Allows you to switch to each channel,
                    to view the description and all the playlists of the channel. Implemented the ability to view
                    the list of videos in each playlist. The opportunity to go to each video, view it, view latest
                    comments, view statistics.
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Facebook API</div>
                <div class="panel-body">
                    The module allows logged in users to manage their pages.
                    To view, create, delete posts. To attach to them images, send links to articles.
                </div>
            </div>

            <div class="text-center">
                <a href="{{ route('control.index') }}" class="btn btn-primary btn-lg">Start <span class="glyphicon glyphicon-arrow-right"></span></a>
            </div>

        </div>
    </div>

@stop