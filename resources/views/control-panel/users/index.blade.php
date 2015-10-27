@extends('layouts.layout-panel')

@section('left-panel')
    @include('layouts/blocks.left-panel')
@stop

@section('content')

    <div class="container-fluid">
        <div class="row page-header">
            <div class="col-md-9">
                <h1>List of users</h1>
            </div>
            <div class="col-md-3 text-right">
                <a href="{{ route('users.create') }}" class="btn btn-success add-user"><i class="mdi-content-add-circle-outline"></i> Add User</a>
            </div>
        </div>
    </div>



    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="col-md-1">Id</th>
                    <th class="col-md-5">Name</th>
                    <th class="col-md-4">Email</th>
                    <th class="col-md-1">Status</th>
                    <th class="col-md-1"></th>
                </tr>
            </thead>
            <tbody>
                @if($users)
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }} {{ $user->surname }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <form action="{{ route('users.edit-status') }}" method="post" class="editUserStatus">
                                    <div class="togglebutton togglebutton-material-light-green-700">
                                        <label>
                                            <input {{ $user->isActive == 0 ? '' : 'checked=""' }} type="checkbox" name="userStatus">
                                            <input type="hidden" name="userId" value="{{ $user->id }}">
                                        </label>
                                    </div>
                                </form>
                            </td>
                            <td>
                                <div class="user-action">
                                    <a href="{{ route('users.edit', array($user->id)) }}"><i class="mdi-content-create editUser tt-on" data-toggle="tooltip" title="Edit User"></i></a>
                                    <i class="mdi-action-delete deleteUser tt-on" data-toggle="tooltip" title="Delete User"
                                       data-user-id="{{ $user->id }}"
                                       data-method="post"
                                       data-action="{{ route('users.destroy') }}"></i>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

@stop