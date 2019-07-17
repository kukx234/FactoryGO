<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vacation;
use App\Models\User;
use App\Classes\VacationQuerys;
use App\Models\UserVacation;
use App\Classes\UserRoles;
use App\Models\Role;

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
                'status' => Vacation::PENDING,
                'user_id' => $currentUserId,
            ]);
            
            return redirect()->route('home')->with([
                'Success' => 'New vacation request successfully added',
            ]);
        }
    }

    public function showMyRequests()
    {
        $vacations = Vacation::with('user')->where('status', Vacation::PENDING)->whereHas('user', function($query){
            $query->where('email', Auth::user()->email);
        })->paginate(10);

        return view('vacations.pendingRequests')->with([
            'vacations' => $vacations,
        ]);  
    }

    public function allVacationRequests()
    {
        if(UserRoles::check() === Role::ADMIN){
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
                'status' => UserVacation::APPROVED,
                'comment' => $request->comment,
            ]);

       }else{
            VacationQuerys::save([
                'id' => $id,
                'status' => UserVacation::DENIED,
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

        $vacations = Vacation::where([
            ['status', Vacation::FINISHED],
            ['user_id', Auth::user()->id],
            ])->paginate(10);

        return view('vacations.myFinishedRequests')->with([
            'vacations' => $vacations,
        ]);     
    }

    public function myFinishedRequestDetails($id)
    {
        $result = VacationQuerys::requestDetails($id);
        echo $result;
        die();
    }

    public function allFinishedRequests()
    {
        if(UserRoles::check() === Role::ADMIN){
            $vacations = Vacation::where('status', Vacation::FINISHED)->paginate(10);
        }else{
            $vacations = Vacation::where('status', Vacation::FINISHED)->whereHas('userVacation', function($query){
                $query->where('user_id', Auth::user()->id);
            })->paginate(10);
        }

        return view('vacations.administrator.allFinishedRequests')->with([
            'vacations' => $vacations,
        ]);
    }

    public function allFinishedRequestDetails($id)
    {
        $result = VacationQuerys::requestDetails($id);
        echo $result;
        die();
    }
}
