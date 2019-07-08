<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserApprover extends Model
{
    public $table = "user_approvers";
    
    protected $fillable = [
        'user_id', 'approver_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
