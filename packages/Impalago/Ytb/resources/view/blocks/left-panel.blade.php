<div class="col-sm-3 col-md-2 sidebar">

    @include('layouts/blocks.profile-left-block')

    @if(isset($subscriptionsItems))
       @foreach($subscriptionsItems as $subItem)
            <div class="media subscriptions-list">
                <a class="pull-left" href="#">
                    <img class="media-object" src="{{ $subItem['snippet']['thumbnails']['default']['url'] }}" alt="{{ $subItem['snippet']['title'] }}">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">{{ $subItem['snippet']['title'] }}</h4>
                </div>
            </div>
       @endforeach
    @endif
</div>