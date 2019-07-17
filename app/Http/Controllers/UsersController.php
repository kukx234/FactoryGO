<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Classes\UsersQuery;
use App\Models\UserApprover;
use App\Models\Role;
use App\Models\UserRole;
use App\Classes\UserRoles;

class UsersController extends Controller
{

    public function showAllUsers()
    {
       return view('users.allUsers')->with([
            'users' => UsersQuery::allUsers(),
       ]);
    }

    public function showEditForm($id)
    {
        $user = User::find($id);
        $approvers = UsersQuery::approvers();
        $roles = Role::where('role_name', '!=', 'Admin')->get();

        if(!$user){
            abort(404);
        }

        return view('users.editUser', [
            'user' => $user,
            'approvers' => $approvers,
            'roles' => $roles,
        ]);
    }

    public function update(Request $request, $id)
    {   
        $user = User::find($id);

        if (!$user) {
            abort(404);
        }

        if($request->submit === 'suspend'){
            echo 'bit ce suspendiran,radi se na tome :)';
            die();
        }

        //user status
        //1- pending
        //2- active
        //3-suspended

        if ($request->role === 'Approver') {
            UserRole::where('user_id', $user->id)->update([ 'role_id' => UserRoles::setAsApprover()]);
        
        }else {
            UserRole::where('user_id', $user->id)->update([ 'role_id' => UserRoles::setAsEmployee()]);
        }

        UserApprover::create([
            'user_id' => $user->id,
            'approver_id' => $request->approvers,
        ]);

        $user->fill($request->all());
        $user->save();

        return redirect()->route('allUsers')->with([
            'Success' => 'User updated successfully',
        ]);
    }
}
