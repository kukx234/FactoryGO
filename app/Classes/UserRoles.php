<?php 

namespace App\Classes;

use Illuminate\Support\Facades\Auth;

class UserRoles 
{
    public static function check()
    {
        foreach (Auth::user()->role as $role) {
            return $role->id;
        }
    }
}