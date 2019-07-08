<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vacation;
use App\Models\User;
use App\Classes\VacationQuerys;
use App\Models\UserVacation;
use App\Classes\UserRoles;

class VacationController extends Controller
{
    public function create(Request $request)
    {
        $today = date('m/d/Y');
        
        if(strtotime($today) > strtotime($request->from) || 
            strtotime($request->to) < strtotime($request->from)){

                return redirect()->back()->with([
                    'Error' => "Please chose date after $today ",
                ]);

        }else{
            $currentUserId = Auth::user()->id;
        
            Vacation::create([
                'from' => $request->from,
                'to' => $request->to,
                'status' => 1,
                'user_id' => $currentUserId,
            ]);

            //status 2 is approved
            //status 3 denied
            
            return redirect()->route('home')->with([
                'Success' => 'New vacation request successfully added',
            ]);
        }
    }

    public function showMyRequests()
    {
        $vacations = Vacation::with('user')->where('status', 1)->whereHas('user', function($query){
            $query->where('email', Auth::user()->email);
        })->paginate(10);

        return view('vacations.pendingRequests')->with([
            'vacations' => $vacations,
        ]);  
    }

    public function allVacationRequests()
    {
        if(UserRoles::check() === 1){
           $vacations =  VacationQuerys::adminVacationRequests();

        }else{
            $vacations = VacationQuerys::approverVacationRequests();
        }
            
        return view('vacations.administrator.allVacationRequests')->with([
            'vacations' => $vacations,
        ]);
    }

    public function deleteRequest($id)
    {
        Vacation::destroy($id);

        return redirect()->back()->with([
            'Success' => 'Request deleted successfully',
        ]);
    }

    public function requestDetails($id)
    {
        $vacations = Vacation::with('user')->where('id', $id)->get();
        $approvers = UserVacation::with('user', 'vacation')->where('vacation_id', $id)->get();

        foreach ($vacations as $vacation) {
            return view('vacations.administrator.requestDetails')->with([
                'vacation' => $vacation,
                'approvers' => $approvers,
            ]);
        }
    }

    public function approve(Request $request, $id)
    {   
       if($request->submit == 'approve'){
            VacationQuerys::save([
                'id' => $id,
                'status' => 2,
                'comment' => $request->comment,
            ]);

       }else{
            VacationQuerys::save([
                'id' => $id,
                'status' => 3,
                'comment' => $request->comment,
            ]);
       }

       VacationQuerys::checkIfFinished($id);
        
       return redirect()->route('allVacationRequests')->with([
            'Success' => 'Response to request saved successfully',
       ]);
    }

    public function myFinishedRequests()
    {

        $vacations = Vacation::with('userVacation')->where([
            ['status',2 ],
            ['user_id', Auth::user()->id],
            ])->get();

        foreach ($vacations as $vacation) {
            echo $vacation->userVacation;
        }
        die();
     /*   $userVacation = UserVacation::where('vacation_id', 4)->get();
        echo $userVacation;
        die(); */
        return view('vacations.myFinishedRequests')->with([
            'vacations' => $vacations,
        ]);     
    }

    public function allFinishedRequests()
    {
        if(UserRoles::check() === 1){
            $vacations = Vacation::where('status', 2)->paginate(10);
        }else{
            $vacations = Vacation::where('status', 2)->whereHas('userVacation', function($query){
                $query->where('user_id', Auth::user()->id);
            })->paginate(10);
        }

        return view('vacations.administrator.allFinishedRequests')->with([
            'vacations' => $vacations,
        ]);
    }

    public function allFinishedRequestDetails($id)
    {
        $status = 2;
        $vacations = Vacation::with('user')->where('id', $id)->paginate(10);
        $approvers = UserVacation::where('vacation_id', $id)->get();
     
        foreach ($approvers as $approver) {
            if($approver->status === 3){
                $status = 3;
            }
        } 
        
        foreach ($vacations as $vacation) {
            return view('vacations.administrator.allFinishedRequestDetails')->with([
                'vacation' => $vacation,
                'approvers' => $approvers,
                'status' => $status,
            ]);
        }
       
    }
}
