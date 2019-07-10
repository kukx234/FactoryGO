<?php 

namespace App\Classes;

use Illuminate\Support\Facades\Auth;
use App\Models\Role;

class UserRoles 
{
    public static function check()
    {
        foreach (Auth::user()->role as $role) {
            return $role->role_name;
        }
    }

    public static function setAsEmployee()
    {
        $roles = Role::all();
        foreach ($roles as $role) {
            if($role->role_name === 'Employee'){
                return $role->id;
            }
        }
    }

    public static function setAsAdmin()
    {
        $roles = Role::all();
        foreach ($roles as $role) {
            if($role->role_name === 'Admin'){
                return $role->id;
            }
        }
    }

    public static function setAsApprover()
    {
        $roles = Role::all();
        foreach ($roles as $role) {
            if($role->role_name === 'Approver'){
                return $role->id;
            }
        }
    }
}