<div class="navbar navbar-inverse navbar-fixed-top top-panel" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">ABC</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/">Dashboard</a></li>
                <li><a href="{{ route('facebook.index') }}">Facebook</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Google <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('ga.index') }}">Google Analytics</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ route('ytb.index') }}">YouTube</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('users.index') }}">Users</a></li>
                <li><a href="{{ route('settings.index') }}">Settings</a></li>
                <li><a href="{{ route('auth.logout') }}">Logout</a></li>
            </ul>
        </div>
    </div>
</div>