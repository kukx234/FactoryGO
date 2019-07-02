<?php 

namespace App\Classes;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UsersQuery 
{
    public static function allUsers()
    {
        return User::where('email', '!=', Auth::user()->email)->paginate(10);
    }

    public static function approvers()
    {
       return User::whereHas('role', function($query){
            $query->where('role_id', 2);
       })->get();
    }
}