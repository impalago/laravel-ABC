<?php

namespace App\Http\Controllers\Settings;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Role;


class RolesController extends Controller
{
    /**
     * Display a listing of the user roles.
     * Edit a listing of the user roles
     * @return \Illuminate\Http\Response
     */
    public function editUserRoles() {

        $roles = Role::all();
        return view('control-panel/settings.user-roles', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function roleCreate()
    {
        $data = Request::all();
        $role = new Role();
        $role->role_title = $data['role_title'];
        $role->role_slug = $data['role_slug'];
        $role->save();
        return redirect(route('settings.user-roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @internal param \Illuminate\Http\Request $request
     */
    public function getRoleUpdate($id)
    {
        $role = Role::find($id);
        return view('control-panel/settings/blocks.role-form-update', ['role' => $role]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @internal param \Illuminate\Http\Request $request
     */
    public function postRoleUpdate($id)
    {
        $data = Request::all();
        $role = Role::find($id);
        $role->role_title = $data['role_title'];
        $role->role_slug = $data['role_slug'];
        $role->save();
        return redirect(route('settings.user-roles'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function roleDestroy($id)
    {
        $role = Role::find($id);
        $role->delete();
        return ('The role is successfully deleted!');
    }
}
