<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vacation extends Model
{
    const PENDING = 'Pending';
    const DENIED = 'Denied';
    const APPROVED = 'Approved';
    
    protected $fillable = [
        'from', 'to','user_id','status',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function userVacation()
    {
        return $this->hasMany('App\Models\UserVacation');
    }
}
