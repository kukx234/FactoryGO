<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    
    public static function allUsers()
    {   
        return User::where('email','!=', Auth::user()->email)->paginate(10);
    }

    public function edit($id)
    {
        $user = User::find($id);
        
        if(!$user){
            abort(404);
        }

        return view('editUser', [
            'user' => $user,
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
