@extends('layouts.layout-panel')

@section('left-panel')
    @include('control-panel/settings/blocks.left-panel')
@stop

@section('content')

    <div class="container-fluid">
        <div class="row page-header">
            <h1>User roles</h1>
        </div>

        @if($errors->all())
            <div class="alert alert-dismissable alert-danger">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <ul class="list-group">
                    @foreach ($errors->all() as $error)
                        <li class="list-group-item">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="col-md-6">Role title</th>
                            <th class="col-md-5">Role slug</th>
                            <th class="col-md-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($roles)
                            @foreach($roles as $role)
                                <tr>
                                    <td>{{ $role->role_title }}</td>
                                    <td>{{ $role->role_slug }}</td>
                                    <td>
                                        <a href="#"
                                           class="update-role"
                                           data-method="post"
                                           data-action="{{ route('settings.get-roles-update', $role->id) }}"><i class="mdi-content-create tt-on" data-toggle="tooltip" title="Update Role"></i></a>
                                        <i class="mdi-action-delete deleteRole tt-on" data-toggle="tooltip" title="Delete Role"
                                           data-role-id="{{ $role->id }}"
                                           data-method="post"
                                           data-action="{{ route('settings.user-roles-destroy', $role->id) }}"></i>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <a href="#" data-toggle="modal" data-target="#addRole" class="btn btn-primary add-role">Add role</a>
        </div>

    </div>

    @include('control-panel/settings/blocks.role-form-create')

@stop