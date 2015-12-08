<div class="col-sm-3 col-md-2 sidebar">

    @include('layouts/blocks.profile-left-block')

    @if(isset($subscriptions))
        <h2 class="list-head">Subscriptions</h2>
            <div class="subscriptions">
                @foreach($subscriptions->getItems() as $subItem)
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
            </div>

    @endif

    @if($subscriptions->getNextPageToken())
        <div class="text-center show-more">
            <a href="#" data-page-token="{{ $subscriptions->getNextPageToken() }}" class="btn btn-primary btn-xs subscriptions-mode">show more</a>
        </div>
    @endif
</div>