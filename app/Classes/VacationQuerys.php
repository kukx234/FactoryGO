<?php 

namespace App\Classes;

use App\Models\Vacation;
use App\Models\UserVacation;
use Illuminate\Support\Facades\Auth;
use App\Models\UserApprover;
use App\Classes\UserRoles;
use App\Models\Role;
use App\Models\User;

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

    public static function checkIfFinished($id , $status) 
    { 
        $user_vacation_approvers = UserVacation::with('vacation')->where('vacation_id', $id)->get();
       
        if(UserRoles::check() === Role::ADMIN){
            Vacation::where('id', $id)->update(['status' => $status]);
            self::reduceVacationDays($id);
        } 

        if( !$user_vacation_approvers->isEmpty() ){
           
            foreach ($user_vacation_approvers as $user_vacation) {
                $user_id = $user_vacation->vacation->user_id;
            }
            
            $user_approvers = UserApprover::with('user')->where('user_id', $user_id)->get();

            if(count($user_vacation_approvers) >= count($user_approvers) &&
                    UserRoles::check() != Role::ADMIN){
             
                Vacation::where('id', $id)->update([ 'status' => $status ]);
                self::reduceVacationDays($id);
            }

        }
    }

    public static function adminVacationRequests()
    {
        return Vacation::with('user','userVacation')->where('status', Vacation::PENDING)
            ->whereDoesntHave('userVacation', function($query){
                $query->where('user_id',  Auth::user()->id);
            })->orderBy('created_at')->paginate(10);
    }

    public static function approverVacationRequests()
    {
        return Vacation::with('user','userVacation')->where('status', Vacation::PENDING)
            ->whereDoesntHave('userVacation', function($query){
                $query->where('user_id', Auth::user()->id);
            })
            ->whereHas('user', function($query){
                $query->whereHas('userApprover',function($q){
                    $q->where('approver_id', Auth::user()->id);
                });
            })->orderBy('created_at')->paginate(10);
    }

    public static function requestDetails($id)
    {
        $vacations = Vacation::with('user')->where('id', $id)->get();
        $approvers = UserVacation::with('user')->where('vacation_id', $id)->get();
  
        foreach ($vacations as $vacation) {
            return view('vacations.myFinishedRequestDetails')->with([
                'vacation' => $vacation,
                'approvers' => $approvers,
                'status' => $vacation->status,
                'countApprovers' => self::countApprovers($vacation->user->id),
            ]);
        }
        
    }

    public static function countApprovers($id)
    {
        $approvers = UserApprover::where('user_id', $id)->get();
        
        return count($approvers);
    }

    public static function reduceVacationDays($id)
    {
        $vacation = Vacation::with('user')->where('id', $id)->first();

        if($vacation->status === Vacation::APPROVED){
            $requested_days = (strtotime($vacation->to) - strtotime($vacation->from)) /86400;

            if($vacation->user->old_vacation <= $requested_days ){
                $residueDays = $requested_days - $vacation->user->old_vacation;
                User::where('email',$vacation->user->email)->update([
                    'old_vacation' => $vacation->user->old_vacation - $vacation->user->old_vacation,
                    'new_vacation' => $vacation->user->new_vacation - $residueDays,
                ]);
            }else{
                User::where('email', $vacation->user->email)->update([
                    'old_vacation' => $vacation->user->old_vacation - $requested_days,
                ]);
            }
        }
    }
    
}