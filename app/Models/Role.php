<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const ADMIN = 'Admin';
    const APPROVER = 'Approver';
    const EMPLOYEE = 'Employee';
    
    protected $fillable = [
        'role_name',
    ];

    public function user()
    {
        return $this->belongsToMany('App\Models\User','user_roles');
    }
}
