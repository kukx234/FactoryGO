<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const PENDING = 'Pending';
    const ACTIVE = 'Active';
    const SUSPENDED = 'Suspended';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','status','old_vacation','new_vacation'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function vacation()
    {
        return $this->hasMany('App\Models\Vacation');
    }

    public function userVacation()
    {
        return $this->hasMany('App\Models\UserVacation');
    }

    public function role()
    {
        return $this->belongsToMany('App\Models\Role','user_roles');
    }

    public function userApprover()
    {
        return $this->hasMany('App\Models\UserApprover');
    }
}
