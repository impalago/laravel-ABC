@extends(config('ytb.views.layout'))

@section('left-panel')
    @include('ytb::blocks.left-panel')
@stop

@section(config('ytb.sections.content'))

    <div class="control">
        <a href="{{ route('ytb.logout') }}" class="btn btn-danger logout"><i class="glyphicon glyphicon-off"></i></a>
    </div>

    <div class="page-header">
        <h1>{{ $channelInfo->getTitle() }}</h1>
    </div>

    <div class="jumbotron">
        {{ $channelInfo->getDescription() }}
    </div>

    @if(isset($playlistsList))
        <div class="page-header">
            <h2>Playlists</h2>
        </div>

        <div class="row grid playlists">
            @foreach($playlistsList as $playlist)
                <div class="col-lg-3 col-md-4 col-sm-6 grid-item">
                    <div class="panel panel-default">
                        <div class="panel-heading"><a href="{{ route('ytb.playlist', $playlist->getId()) }}" title="{{ $playlist['snippet']['title'] }}">{{ $playlist['snippet']['title'] }}</a></div>
                        <div class="panel-body">
                            <a href="{{ route('ytb.playlist', $playlist->getId()) }}" title="{{ $playlist['snippet']['title'] }}">
                                <img src="{{ $playlist['snippet']['thumbnails']['medium']['url'] }}" alt="">
                            </a>
                        </div>
                        <div class="panel-footer">{{ $playlist['contentDetails']['itemCount'] }} video</div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif



@stop