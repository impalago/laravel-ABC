@extends(config('ytb.views.layout'))

@section(config('ytb.sections.content'))

    <div class="row login">
        <div class="alert alert-warning text-center">
            <h2>You need to authorize access before proceeding.</h2>
            <div>
                <a href="{{ $loginUrl }}" class="btn btn-primary btn-lg">Authorize access</a>
            </div>
        </div>
    </div>

@stop