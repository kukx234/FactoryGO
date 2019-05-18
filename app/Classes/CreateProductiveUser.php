<?php

namespace App\Classes;

use App\User;

class CreateProductiveUser
{
 
    public static function create(array $data)
    {
        return User::create([
            'email' => $data['email'],
            'name'  => $data['name'],
        ]);
    }

}
