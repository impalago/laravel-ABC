<?php

namespace App\Http\Controllers\Settings;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Role;
use App\Permission;
use App\Http\Requests\RolesRequest;


class RolesController extends Controller
{
    /**
     * Display a listing of the user roles.
     * Edit a listing of the user roles
     * @return \Illuminate\Http\Response
     */
    public function editUserRoles()
    {

        $roles = Role::all();
        $permissions = Permission::all();
        return view('control-panel/settings.user-roles', ['roles' => $roles, 'permissions' => $permissions]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @param RolesRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function roleCreate(RolesRequest $request)
    {

        $role = new Role();
        $role->role_title = $request->role_title;
        $role->role_slug = $request->role_slug;
        $role->save();
        $insertId = $role->id;

        if (isset($request->permission_role)) {
            $permission_role = [];
            foreach ($request->permission_role as $pr) {
                $permission_role[] = array('permission_id' => $pr, 'role_id' => $insertId);
            }

            \DB::table('permission_role')->insert($permission_role);
        }

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
        $permissions = Permission::all();
        for ($i = 0; isset($permissions[$i]); $i++) {
            $permissionsCheck = \DB::table('permission_role')
                ->where('role_id', $id)
                ->where('permission_id', $permissions[$i]['id'])
                ->first();

            if ($permissionsCheck) {
                $permissions[$i]['check'] = true;
            } else {
                $permissions[$i]['check'] = false;
            }
        }

        return view('control-panel/settings/blocks.role-form-update', ['role' => $role, 'permissions' => $permissions]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param RolesRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postRoleUpdate(RolesRequest $request, $id)
    {
        $role = Role::find($id);
        $role->role_title = $request->role_title;
        $role->role_slug = $request->role_slug;
        $role->save();

        \DB::table('permission_role')->where('role_id', $id)->delete();

        if (isset($request->permission_role)) {
            $permission_role = [];
            foreach ($request->permission_role as $pr) {
                $permission_role[] = array('permission_id' => $pr, 'role_id' => $id);
            }

            \DB::table('permission_role')->insert($permission_role);
        }

        return redirect(route('settings.user-roles'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function roleDestroy($id)
    {
        $role = Role::find($id);
        $role->delete();
        return ('The role is successfully deleted!');
    }
}
