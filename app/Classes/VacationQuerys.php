<?php 

namespace App\Classes;

use App\Models\Vacation;
use App\Models\UserVacation;
use Illuminate\Support\Facades\Auth;
use App\Models\UserApprover;

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

    public static function checkIfFinished($id)
    {
        $user_vacation_approvers = UserVacation::with('vacation')->where('vacation_id', $id)->get();

        if( !$user_vacation_approvers->isEmpty() ){
           
            foreach ($user_vacation_approvers as $user_vacation) {
                $user_id = $user_vacation->vacation->user_id;
            }
            
            $user_approvers = UserApprover::with('user')->where('user_id', $user_id)->get();
    
            if(count($user_vacation_approvers) >= count($user_approvers)){
                //u tablici vacation ce biti status 1 pending i status 2 finished
                Vacation::where('id', $id)->update([ 'status' => Vacation::FINISHED ]);
            }
        }
    }

    public static function adminVacationRequests()
    {
        return Vacation::with('user','userVacation')->where('status', Vacation::PENDING)
            ->whereDoesntHave('userVacation', function($query){
                $query->where('user_id',  Auth::user()->id);
            })->paginate(10);
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
            })->paginate(10);
    }

    public static function requestDetails($id)
    {
        $status = 2;
        $vacations = Vacation::with('user')->where('id', $id)->get();
        $approvers = UserVacation::where('vacation_id', $id)->get();
     
        foreach ($approvers as $approver) {
            if($approver->status === 3){
                $status = 3;
            }
        } 

        foreach ($vacations as $vacation) {
            return view('vacations.myFinishedRequestDetails')->with([
                'vacation' => $vacation,
                'approvers' => $approvers,
                'status' => $status,
            ]);
        }
        

    }
}