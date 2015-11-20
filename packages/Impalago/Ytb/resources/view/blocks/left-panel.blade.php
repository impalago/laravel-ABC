<div class="col-sm-3 col-md-2 sidebar">

    @include('layouts/blocks.profile-left-block')

    @if(isset($subscriptionsItems))
        <h2 class="list-head">Subscriptions</h2>
       @foreach($subscriptionsItems as $subItem)
            <div class="media subscriptions-list">
                <a class="pull-left" href="{{ route('ytb.channel', $subItem['snippet']['resourceId']['channelId']) }}">
                    <img class="media-object" src="{{ $subItem['snippet']['thumbnails']['default']['url'] }}" alt="{{ $subItem['snippet']['title'] }}">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">
                        <a href="{{ route('ytb.channel', $subItem['snippet']['resourceId']['channelId']) }}" class="tt-on-bottom" data-toggle="tooltip" title="{{ $subItem['snippet']['title'] }}">{{ $subItem['snippet']['title'] }}</a>
                    </h4>
                </div>
            </div>
       @endforeach
    @endif

    @if(isset($subscriptionsNextPage))
        <div class="text-center">
            <a href="" class="btn btn-primary btn-xs">show more</a>
        </div>
    @endif
</div>