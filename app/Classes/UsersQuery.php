<?php 

namespace App\Classes;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Classes\UserRoles;

class UsersQuery 
{
    public static function allUsers()
    {
        if(UserRoles::check() === 1){
            return User::where('email', '!=', Auth::user()->email)->paginate(10);

        }else{
            return User::whereHas('userApprover',function($query){
                $query->where('approver_id', Auth::user()->id);
            })->paginate(10);
        }
        
    }

    public static function approvers()
    {
       return User::whereHas('role', function($query){
            $query->where('role_id', 2);
       })->get();
    }
}