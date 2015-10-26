<div class="modal fade" id="addRole">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h2 class="modal-title">Create role</h2>
            </div>
            <div class="modal-body">

                {!! Form::open(array('route' => 'settings.user-roles-create')) !!}

                <div class="form-group">
                    {!! Form::label('role_title', 'Role title') !!}
                    {!! Form::text('role_title', null, array('class' => 'form-control')) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('role_slug', 'Role slug') !!}
                    {!! Form::text('role_slug', null, array('class' => 'form-control')) !!}
                </div>


                <div class="checkbox permission_role">
                    @foreach($permissions as $permission)
                        <label>
                            {!! Form::checkbox('permission_role[]', $permission->id) !!} {{ $permission->permission_title }}
                        </label>
                    @endforeach
                </div>

                {!! Form::submit('Save', array('class' => 'btn btn-success')) !!}

                {!! Form::close() !!}

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>