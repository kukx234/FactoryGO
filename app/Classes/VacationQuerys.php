<?php 

namespace App\Classes;

use App\Models\Vacation;
use App\Models\UserVacation;
use Illuminate\Support\Facades\Auth;

class VacationQuerys 
{
    public static function save(array $data)
    {
        UserVacation::create([
            'user_id' => Auth::user()->id,
            'vacation_id' => $data['id'],
            'comment' => $data['comment'],
            'status' => $data['status'],
        ]);
    }
}