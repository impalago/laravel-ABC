@extends(config('ytb.views.layout'))

@section(config('ytb.sections.content'))

    <div class="control">
        <a href="/ytb/logout" class="btn btn-danger logout"><i class="glyphicon glyphicon-off"></i></a>
    </div>

    <div class="page-header">
        <h1>{{ $video['snippet']['title'] }}</h1>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="videoWrapper">
                {!! $video['player']['embedHtml'] !!}
            </div>
        </div>
        <div class="col-md-4">

            <div class="panel panel-primary text-center num_view">
                <div class="panel-heading">
                    <h3 class="panel-title">Statistic</h3>
                </div>
                <div class="panel-body"><i class="glyphicon glyphicon-eye-open"></i> {{ $video["statistics"]["viewCount"] }}</div>
                <div class="panel-footer">
                    <span><i class="glyphicon glyphicon-thumbs-up"></i> {{ $video["statistics"]["likeCount"] }}</span>
                    <span><i class="glyphicon glyphicon-thumbs-down"></i> {{ $video["statistics"]["dislikeCount"] }}</span>
                    <span><i class="glyphicon glyphicon-heart"></i> {{ $video["statistics"]["favoriteCount"] }}</span>
                    <span><i class="glyphicon glyphicon-bullhorn"></i> {{ $video["statistics"]["commentCount"] }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row video-description">
        <div class="col-md-12">
            {{ $video['snippet']['description'] }}
        </div>
    </div>

    <div class="row comments">
        <div class="col-md-12">

            <h2>Last comments</h2>

            @if(count($comments) != 0)
                @foreach($comments as $comment)
                    <div class="media">
                        <a class="pull-left" href="{{ $comment['snippet']['topLevelComment']['snippet']['authorChannelUrl'] }}">
                            <img class="media-object" src="{{ $comment['snippet']['topLevelComment']['snippet']['authorProfileImageUrl'] }}" alt="{{ $comment['snippet']['topLevelComment']['snippet']['authorDisplayName'] }}">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading">{{ $comment['snippet']['topLevelComment']['snippet']['authorDisplayName'] }}</h4>
                            {{ $comment['snippet']['topLevelComment']['snippet']['textDisplay'] }}
                        </div>
                    </div>
                @endforeach
            @else
                No comments
            @endif
        </div>
    </div>

@stop