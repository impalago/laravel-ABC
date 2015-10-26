<div class="modal fade" id="updatePermission">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h2 class="modal-title">Update permission</h2>
            </div>
            <div class="modal-body">

                {!! Form::open(array('route' => array('settings.permission-update', $permission->id))) !!}

                <div class="form-group">
                    {!! Form::label('permission_title', 'Permission title') !!}
                    {!! Form::text('permission_title', $permission->permission_title, array('class' => 'form-control')) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('permission_slug', 'Permission slug') !!}
                    {!! Form::text('permission_slug', $permission->permission_slug, array('class' => 'form-control')) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('permission_description', 'Permission description') !!}
                    {!! Form::text('permission_description', $permission->permission_description, array('class' => 'form-control')) !!}
                </div>

                {!! Form::submit('Save', array('class' => 'btn btn-success save-update-permission')) !!}

                {!! Form::close() !!}

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>