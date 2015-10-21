<div class="navbar navbar-inverse navbar-fixed-top top-panel" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Project name</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Settings</a></li>
                <li><a href="{{ route('users.index') }}">Users</a></li>
                <li><a href="#">Profile</a></li>
                <li><a href="{{ route('auth.logout') }}">Logout</a></li>
            </ul>
        </div>
    </div>
</div>