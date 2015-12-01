@extends('layouts/layout-panel')

@section('left-panel')
    @include('control-panel/google/blocks.left-panel')
@stop

@section('content')

    <div class="container-fluid">
        <div class="row page-header">
            <h1>Google analytics accounts</h1>
        </div>
    </div>

    @if(isset($error))
        <div class="alert alert-dismissable alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <ul class="list-group">
                <li class="list-group-item">{{ $error }}</li>
            </ul>
        </div>
    @endif

    <div class="panel-group" id="accounts">
        @if(isset($accounts))
            @foreach($accounts as $account)
                <div class="panel panel-default account"
                     data-method="get"
                     data-action="{{ route('ga.account', $account->getId()) }}">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="account-info" data-toggle="collapse" data-parent="#accordion" href="#collapse-{{ $account->getId() }}">
                                <span class="glyphicon glyphicon-folder-close"></span> {{ $account->getName() }}
                            </a>
                        </h4>
                    </div>
                    <div id="collapse-{{ $account->getId() }}" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="show-info"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>



@stop