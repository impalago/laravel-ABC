@extends(config('ytb.views.layout'))

@section(config('ytb.sections.content'))

    <div class="row">
        <div class="text-center">
            <a href="{{ $loginUrl }}" class="btn btn-primary btn-lg">Log In</a>
        </div>
    </div>

@stop