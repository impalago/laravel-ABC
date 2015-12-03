<div class="panel panel-default profile">
    @if(!empty(Auth::user()->avatar))
        <div class="panel-body">
            <img class="img-rounded" src="{{ Auth::user()->avatar }}" alt="">
        </div>
    @endif
    <div class="panel-footer">{{ Auth::user()->name }} {{ Auth::user()->surname }}</div>
</div>