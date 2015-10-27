<?php

namespace App\Http\Controllers\Users;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Support\Facades\Input;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('control-panel/users.index', ['users' => $users]);
    }

    public function editStatusAjax()
    {
        $data = Input::all();
        if (isset($data['userId'])) {
            $user = User::find($data['userId']);
            $user->isActive = isset($data['userStatus']) ? 1 : 0;
            $user->save();
            return "The user status is changed successfully!";
        } else {
            return "Error!";
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all();
        $userRole = \DB::table('role_user')->where('user_id', $id)->first();
        if(isset($userRole->role_id)) {
            $userRole = $userRole->role_id;
        }
        return view('control-panel/users.edit', ['user' => $user, 'roles' => $roles, 'userRole' => $userRole]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id)
    {
        $user = User::find($id);
        $data = Input::all();
        $user->name = $data['name'];
        $user->surname = $data['surname'];
        $user->email = $data['email'];
        $user->isActive = isset($data['isActive']) ? 1 : 0;
        $user->save();
        $userRole = \DB::table('role_user')->where('user_id', $id)->first();
        if (isset($userRole)) {
            if ($userRole->role_id != $data['role']) {
                \DB::table('role_user')->where('user_id', $id)->update(array('role_id' => $data['role']));
            }
        } else {
            \DB::table('role_user')->insert(
                array('role_id' => $data['role'], 'user_id' => $id)
            );
        }
        return redirect(route('users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $data = Input::all();
        if (isset($data['userId'])) {
            $user = User::find($data['userId']);
            $user->delete();
            return "The user is successfully deleted!";
        } else {
            return "Error!";
        }
    }
}
