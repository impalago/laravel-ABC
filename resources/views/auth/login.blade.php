@extends('layouts.layout-auth')

@section('content')

    <div class="container-fluid content">
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4">
                <h1 class="text-center login-title">Log In</h1>
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

                    <form method="POST" action="/auth/login" class="form-signin">
                        {!! csrf_field() !!}
                        <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" required autofocus>
                        <input type="password" name="password"  class="form-control" placeholder="Password" required>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember"> Remember Me
                            </label>
                        </div>
                        <button class="btn btn-lg btn-primary btn-block" type="submit">
                            Sign in</button>

                        <a href="{{ route('auth.facebook') }}" class="btn btn-block btn-social btn-facebook">
                            <span class="fa fa-facebook"></span> Sign in with Facebook
                        </a>

                        <a href="{{ route('auth.google') }}" class="btn btn-block btn-social btn-google">
                            <span class="fa fa-google"></span> Sign in with Google
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop