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
                            <th class="col-md-3">Permission title</th>
                            <th class="col-md-3">Permission slug</th>
                            <th class="col-md-5">Permission description</th>
                            <th class="col-md-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($permissions)
                            @foreach($permissions as $permission)
                                <tr>
                                    <td>{{ $permission->permission_title }}</td>
                                    <td>{{ $permission->permission_slug }}</td>
                                    <td>{{ $permission->permission_description }}</td>
                                    <td>
                                        <a href="#"
                                           class="update-permission"
                                           data-method="post"
                                           data-action="{{ route('settings.get-permission-update', $permission->id) }}"><i class="mdi-content-create tt-on" data-toggle="tooltip" title="Update permission"></i></a>
                                        <i class="mdi-action-delete deletePermission tt-on" data-toggle="tooltip" title="Delete permission"
                                           data-role-id="{{ $permission->id }}"
                                           data-method="post"
                                           data-action="{{ route('settings.permission-destroy', $permission->id) }}"></i>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <a href="#" data-toggle="modal" data-target="#addPermission" class="btn btn-primary add-permission">Add permission</a>
        </div>

    </div>

    @include('control-panel/settings/blocks.permission-form-create')

@stop