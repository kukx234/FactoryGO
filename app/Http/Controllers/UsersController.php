<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Classes\UsersQuery;
use App\Models\UserApprover;

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

        if(!$user){
            abort(404);
        }

        return view('users.editUser', [
            'user' => $user,
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
            echo 'bit ce suspendiran,radi se na tome :)';
            die();
        }

        //user status
        //1- pending
        //2- active
        //3-suspended

        UserApprover::create([
            'user_id' => $user->id,
            'approver_id' => $request->approvers,
        ]);

        $user->fill($request->all());
        $user->save();

        return redirect()->route('home')->with([
            'Success' => 'User updated successfully',
        ]);
    }
}
