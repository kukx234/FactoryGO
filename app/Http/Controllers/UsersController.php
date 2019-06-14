<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    
    public static function allUsers()
    {   
        return User::paginate(10);
    }
}
