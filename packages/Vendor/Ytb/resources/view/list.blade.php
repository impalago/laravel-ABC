@extends(config('ytb.views.layout'))

@section(config('ytb.sections.content'))

    <div class="control">
        <a href="/ytb/logout" class="btn btn-danger logout"><i class="glyphicon glyphicon-off"></i></a>
    </div>

    <div class="page-header">
        <h1>List video</h1>
    </div>

    <div class="row grid">
        @foreach($videos as $video)
            <div class="col-sm-6 col-md-4 grid-item">
                <div class="thumbnail">
                    <img src="{{ $video['snippet']['thumbnails']['medium']['url'] }}" alt="">
                    <div class="caption">
                        <h3>{{ $video['snippet']['title'] }}</h3>
                        <p>
                            <a href="/ytb/video/{{ $video->getId() }}" title="{{ $video['snippet']['title'] }}" class="btn btn-primary btn-material-green-500" role="button">Read more</a>
                        </p>
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