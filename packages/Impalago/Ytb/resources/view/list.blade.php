@extends(config('ytb.views.layout'))

@section('left-panel')
    @include('ytb::blocks.left-panel')
@stop

@section(config('ytb.sections.content'))

    <div class="control">
        <a href="{{ route('ytb.logout') }}" class="btn btn-danger logout"><i class="glyphicon glyphicon-off"></i></a>
    </div>

    <div class="page-header">
        <h1>List video</h1>
    </div>

    <div class="row grid">
        @foreach($videos as $video)
            <div class="col-lg-3 col-md-4 col-sm-6 grid-item">
                <div class="thumbnail">
                    <a href="/ytb/video/{{ $video['snippet']['resourceId']['videoId'] }}" title="{{ $video['snippet']['title'] }}">
                        <img src="{{ $video['snippet']['thumbnails']['medium']['url'] }}" alt="">
                    </a>
                    <div class="caption">
                        <h3>
                            <a href="/ytb/video/{{ $video['snippet']['resourceId']['videoId'] }}" title="{{ $video['snippet']['title'] }}">{{ $video['snippet']['title'] }}</a>
                        </h3>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="text-center">
        <ul class="pagination">
            <li @if($videos->getPrevPageToken() == null) class="disabled" @endif>
                <a href="/ytb?page={{$videos->getPrevPageToken()}}">Prev «</a>
            </li>
            <li @if($videos->getNextPageToken() == null) class="disabled" @endif>
                <a href="/ytb?page={{$videos->getNextPageToken()}}">Next »</a>
            </li>
        </ul>
    </div>

@stop