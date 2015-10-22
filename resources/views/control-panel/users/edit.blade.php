@extends('layouts.layout-panel')

@section('left-panel')
    @include('control-panel/users/blocks.left-panel')
@stop

@section('content')

    <div class="container-fluid">
        <div class="row page-header">
            <div class="col-md-9">
                <h1>Add User</h1>
            </div>
        </div>
    </div>

    <div class="container-fluid bg-white user-create">
        <div class="row">
            <div class="col-md-12">

                    @if($errors->all())
                        <div class="alert alert-dismissable alert-danger">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <ul class="list-group">
                                @foreach ($errors->all() as $error)
                                    <li class="list-group-item">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="form-horizontal" method="POST" action="{{ route('users.edit-post', array($user->id)) }}">
                        <fieldset>
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label for="inputName" class="col-md-2 control-label">Name</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" placeholder="Name" name="name" value="{{ $user->name }}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputSurname" class="col-md-2 control-label">Surname</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" placeholder="Surname" name="surname" value="{{ $user->surname }}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-md-2 control-label">Email</label>
                                <div class="col-md-10">
                                    <input type="email" class="form-control" placeholder="Email" name="email" value="{{ $user->email }}" required >
                                </div>
                            </div>
                            <div class="col-md-10 col-md-offset-2 pl0">
                                <select class="form-control" id="select" name="isRole">
                                    <option value="1">Admin</option>
                                </select>
                                <div class="checkbox">
                                    <label>
                                        <input {{ $user->isActive == 0 ? '' : 'checked=""' }} type="checkbox" name="isActive"> Active
                                    </label>
                                </div>
                                <button class="btn btn-success add-user" type="submit">Edit User</button>
                            </div>


                        </fieldset>
                    </form>

                </div>
            </div>
        </div>
    </div>

@stop