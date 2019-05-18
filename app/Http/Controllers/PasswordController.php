<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class PasswordController extends Controller
{
    public function changePassword(ChangePasswordRequest $request)
    {   
        $id = Auth::id();
        $password = Hash::make($request->post('password'));

        User::where('id',$id)->update(['password' => $password]);

        return redirect()->route('home');
    }
}
