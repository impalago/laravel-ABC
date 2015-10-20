@extends('layout')

@section('content')

        <div class="content">
            <div class="row">
                <div class="col-sm-6 col-md-4 col-md-offset-4">
                    <h1 class="text-center login-title">New user registration</h1>
                    <div class="account-wall">
                        <span class="glyphicon glyphicon-user"></span>

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

                        <form class="form-signin" method="POST" action="/auth/register">
                            {!! csrf_field() !!}
                            <input type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name') }}" required autofocus>
                            <input type="text" class="form-control" placeholder="Surname" name="surname" value="{{ old('surname') }}" required autofocus>
                            <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" required >
                            <input type="password" class="form-control" placeholder="Password" name="password" required>
                            <input type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation" required>
                            <select class="form-control" id="select" name="isRole">
                                <option value="1">Admin</option>
                            </select>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="isActive" required> Active
                                </label>
                            </div>
                            <button class="btn btn-lg btn-primary btn-block" type="submit">
                                Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

@stop