@extends(config('ytb.views.layout'))

@section('left-panel')
    @include('ytb::blocks.left-panel')
@stop

@section(config('ytb.sections.content'))

    <div class="control">
        <a href="{{ route('ytb.logout') }}" class="btn btn-danger logout"><i class="glyphicon glyphicon-off"></i></a>
    </div>

    <div class="page-header">
        <h1>{{ isset($pageInfo[0]['snippet']) ? $pageInfo[0]['snippet']->getTitle() : 'List video' }}</h1>
    </div>

    <div class="row grid">
        @foreach($videos as $video)
            <div class="col-lg-6 col-md-6 col-sm-12 grid-item">
                <div class="thumbnail">
                    <a href="{{ route('ytb.video', ($video['snippet']['resourceId']['videoId'] ? $video['snippet']['resourceId']['videoId'] : $video->getId())) }}" title="{{ $video['snippet']['title'] }}">
                        <img src="{{ $video['snippet']['thumbnails']['high']['url'] }}" alt="">
                    </a>
                    <div class="caption">
                        <h3>
                            <a href="{{ route('ytb.video', ($video['snippet']['resourceId']['videoId'] ? $video['snippet']['resourceId']['videoId'] : $video->getId())) }}" title="{{ $video['snippet']['title'] }}">{{ $video['snippet']['title'] }}</a>
                        </h3>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($videos->getPrevPageToken() or $videos->getNextPageToken())
        <div class="text-center">
            <ul class="pagination">
                <li @if($videos->getPrevPageToken() == null) class="disabled" @endif>
                    <a href="?page={{$videos->getPrevPageToken()}}">Prev «</a>
                </li>
                <li @if($videos->getNextPageToken() == null) class="disabled" @endif>
                    <a href="?page={{$videos->getNextPageToken()}}">Next »</a>
                </li>
            </ul>
        </div>
    @endif
@stop