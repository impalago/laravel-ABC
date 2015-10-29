<div class="col-sm-3 col-md-2 sidebar">

    <div class="panel panel-default profile">
        <div class="panel-body">
            <img class="img-rounded" src="{{ Auth::user()->avatar }}" alt="...">
        </div>
        <div class="panel-footer">{{ Auth::user()->name }} {{ Auth::user()->surname }}</div>
    </div>

    <ul class="nav nav-sidebar">
        <li class="active"><a href="#">Overview</a></li>
        <li><a href="#">Reports</a></li>
        <li><a href="#">Analytics</a></li>
        <li><a href="#">Export</a></li>
    </ul>

</div>