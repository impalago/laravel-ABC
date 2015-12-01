<div class="col-sm-3 col-md-2 sidebar">
    @include('layouts/blocks.profile-left-block')

    <ul class="nav nav-sidebar">
        <li><a href="{{ route('settings.user-roles') }}">User roles</a></li>
        <li><a href="{{ route('settings.permissions') }}">Permissions</a></li>
    </ul>
</div>