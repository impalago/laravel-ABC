@extends('layouts.layout-panel')

@section('left-panel')
    @include('layouts/blocks.left-panel')
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

                    <form class="form-horizontal" method="POST" action="{{ route('users.create') }}">
                        <fieldset>
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label for="inputName" class="col-md-2 control-label">Name</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name') }}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-md-2 control-label">Email</label>
                                <div class="col-md-10">
                                    <input type="email" class="form-control" placeholder="Email" name="email" value="" required >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword" class="col-md-2 control-label">Password</label>
                                <div class="col-md-10">
                                    <input type="password" class="form-control" placeholder="Password" name="password" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword_confirmation" class="col-md-2 control-label">Confirm Password</label>
                                <div class="col-md-10">
                                    <input type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="selectRole" class="col-md-2 control-label">Role</label>
                                <div class="col-md-10">
                                    <select class="form-control" id="select" name="role">
                                        @if($roles)
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->role_title }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-10 col-md-offset-2 pl0">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="isActive"> Active
                                    </label>
                                </div>
                                <button class="btn btn-success add-user" type="submit">Add User</button>
                            </div>


                        </fieldset>
                    </form>

                </div>
            </div>
        </div>
    </div>

@stop