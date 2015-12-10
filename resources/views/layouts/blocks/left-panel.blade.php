<div class="col-sm-3 col-md-2 sidebar">

    @include('layouts/blocks.profile-left-block')

    <ul class="nav nav-sidebar">
        <li><a href="{{ route('ga.index') }}">Google Analytics</a></li>
        <li><a href="{{ route('ytb.index') }}">YouTube</a></li>
        <li><a href="{{ route('facebook.index') }}">Facebook</a></li>
    </ul>

</div>