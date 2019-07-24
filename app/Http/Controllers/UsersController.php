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

    public function userInfo($id)
    { 
        $approvers = [];

        $user_approvers =  UserApprover::where('user_id', $id)->get();
        foreach ($user_approvers as $user_approver) {
            $approvers[] = User::find($user_approver->approver_id);
        }

        return view('users.userInfo')->with([
            'user' => User::find($id),
            'approvers' => $approvers,
        ]);
    }

    public function update(Request $request, $id)
    {   
        $user = User::find($id);

        if (!$user) {
            abort(404);
        }

        if($request->submit === 'suspend'){
            $user->update(['status' => User::SUSPENDED]);
        }

        if($request->submit === 'saveAndActivate'){
            if($user->status === User::PENDING){
                $user->update([ 
                    'activated_at' => date('Y-m-d H:i:s') ,
                    'requested_days' => 0,
                    ]);
            }
            $user->update([ 'status' => User::ACTIVE ]);
        }
        if ($request->role === 'Approver') {
            UserRole::where('user_id', $user->id)->update([ 'role_id' => UserRoles::setAsApprover()]);
        
        }else {
            UserRole::where('user_id', $user->id)->update([ 'role_id' => UserRoles::setAsEmployee()]);
        }

        $users = User::with('userApprover')->where('id', $user->id)->whereHas('userApprover', function($query) use($request){
            $query->where('approver_id', $request->approvers);
        })->get();

        if($users->isEmpty()){
            if($request->approvers != 0){
                UserApprover::create([
                    'user_id' => $user->id,
                    'approver_id' => $request->approvers,
                ]);
            }
        }

        $user->fill($request->all());
        $user->save();

        return redirect()->route('allUsers')->with([
            'Success' => 'User updated successfully',
        ]);
    }
}
