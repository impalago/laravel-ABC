<div class="col-sm-3 col-md-2 sidebar">
    <ul class="nav nav-sidebar">
        @foreach($pages as $page)
            <li><a href="{{ route('fb.page', $page['id']) }}">{{ $page['name'] }}</a></li>
        @endforeach
    </ul>
</div>