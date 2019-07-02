<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductiveUserRequest;
use App\Classes\ProductiveUser;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductiveUsersController extends Controller
{   
    public function signUp(ProductiveUserRequest $request)
    {
        $productive_signup = new ProductiveUser;

        $statusCode = $productive_signup->signUp([
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($statusCode === 201) {
            return redirect()->route('home');

        }else{
            return redirect()->route('signUpWithProductiveForm')
                ->with(['Error' => 'Email and Password do not match our records']);
        }
    }

    public static function addUserList()
    {   
        $allUsers = ProductiveUser::searchProductiveUsers();
        $users = [];

        foreach ($allUsers as $user) {
            if($user->attributes->email != Auth::user()->email){
                $users[] = $user;
            }
        }
    
        return view('users.addUser')->with([
            'allUsers' => $users,
        ]);
    }

    public function find(Request $request)
    {
        $users = [];
        $allUsers = ProductiveUser::searchProductiveUsers();

        foreach ($allUsers as $user) {
           if($user->attributes->email == $request->email){
                $users[] = $user;
                return view('users.addUser')->with([
                    'allUsers' => $users,
                ]);
           }
        }

        return redirect()->route('addUser')->with([
            'Error' => "User with email $request->email is not found",
        ]);
    }

    public function saveNewUser(Request $request)
    {
        $allUsers = ProductiveUser::searchProductiveUsers();

        foreach ($allUsers as $user) {
            if($user->id === $request->id){
                ProductiveUser::create([
                    'email' => $user->attributes->email,
                    'name' => $user->attributes->first_name,
                ]);
            }
         }

        if(!session('Error')){
             return redirect()->route('addUser')->with([
                'Success' => 'User added successfully',
             ]);
         }else{
            return redirect()->route('addUser');
         }
    }
}
