<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Classes\UsersQuery;

class UsersController extends Controller
{

    public function showAllUsers()
    {
       return view('users.allUsers')->with([
            'users' => UsersQuery::allUsers(),
       ]);
    }

    public function edit($id)
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

        $user->fill($request->all());
        $user->save();

        return redirect()->route('home')->with([
            'Success' => 'User updated successfully',
        ]);
    }
}
