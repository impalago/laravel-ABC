<div class="panel panel-default profile">
    <div class="panel-body">
        <img class="img-rounded" src="{{ Auth::user()->avatar }}" alt="...">
    </div>
    <div class="panel-footer">{{ Auth::user()->name }} {{ Auth::user()->surname }}</div>
</div>