<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVacation extends Model
{
    public $table = "user_vacations";

    protected $fillable = [
        'user_id', 'vacation_id','comment','status'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function vacation()
    {
        return $this->belongsTo('App\Models\Vacation');
    }
}
