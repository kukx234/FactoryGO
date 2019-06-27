<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vacation extends Model
{
    protected $fillable = [
        'from', 'to','users_id','status',
    ];

    public function users()
    {
        return $this->belongsTo('App\Models\User');
    }
}
