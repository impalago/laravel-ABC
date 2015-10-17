@extends(config('ytb.views.layout'))

@section(config('ytb.sections.content'))
    <h1>List video</h1>

    <div class="row">
        @foreach($videos as $video)
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    <img src="{{ $video['snippet']['thumbnails']['medium']['url'] }}" alt="">
                    <div class="caption">
                        <h3>{{ $video['snippet']['title'] }}</h3>
                        <p><a href="http://youtube.com/watch?v={{ $video->getId() }}" title="{{ $video['snippet']['title'] }}" class="btn btn-default" role="button">Кнопка</a></p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


@stop