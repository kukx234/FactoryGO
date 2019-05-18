<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductiveUserRequest;
use App\Classes\ProductiveSignUp;

class SignUpProductiveController extends Controller
{
   
    public function signUp(ProductiveUserRequest $request)
    {
        $productive_signup = new ProductiveSignUp;

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
}
