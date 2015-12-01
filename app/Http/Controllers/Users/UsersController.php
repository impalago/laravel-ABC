<?php

namespace App\Http\Controllers\Users;

use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\UsersRequest;

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
        if (isset($userRole->role_id)) {
            $userRole = $userRole->role_id;
        }
        return view('control-panel/users.edit', ['user' => $user, 'roles' => $roles, 'userRole' => $userRole]);
    }


    /**
     *  Update the specified resource in storage.
     *
     * @param UsersRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UsersRequest $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->isActive = isset($request->isActive) ? 1 : 0;
        $user->save();
        $userRole = \DB::table('role_user')->where('user_id', $id)->first();
        if (isset($userRole)) {
            if ($userRole->role_id != $request->role) {
                \DB::table('role_user')->where('user_id', $id)->update(array('role_id' => $request->role));
            }
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
