<?php

namespace App\Http\Controllers\Settings;

use Request;
use App\Http\Controllers\Controller;
use App\Permission;
use App\Http\Requests\PermissionsRequest;


class PermissionsController extends Controller
{
    /**
     * Display a listing of the user roles.
     * Edit a listing of the user roles
     * @return \Illuminate\Http\Response
     */
    public function editPermissions()
    {

        $permissions = Permission::all();
        return view('control-panel/settings.permissions', ['permissions' => $permissions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param PermissionsRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function permissionCreate(PermissionsRequest $request)
    {
        $permission = new Permission();
        $permission->permission_title = $request->permission_title;
        $permission->permission_slug = $request->permission_slug;
        $permission->permission_description = $request->permission_description;
        $permission->save();
        return redirect(route('settings.permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @internal param \Illuminate\Http\Request $request
     */
    public function getPermissionUpdate($id)
    {
        $permission = Permission::find($id);
        return view('control-panel/settings/blocks.permission-form-update', ['permission' => $permission]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PermissionsRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postPermissionUpdate(PermissionsRequest $request, $id)
    {
        $permission = Permission::find($id);
        $permission->permission_title = $request->permission_title;
        $permission->permission_slug = $request->permission_slug;
        $permission->permission_description = $request->permission_description;
        $permission->save();
        return redirect(route('settings.permissions'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function permissionDestroy($id)
    {
        $role = Permission::find($id);
        $role->delete();
        return ('The permission is successfully deleted!');
    }
}
