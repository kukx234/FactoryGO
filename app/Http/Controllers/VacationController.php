<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vacation;
use App\Models\User;

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
                'users_id' => $currentUserId,
            ]);

            //status 1 is pending
            //status 2 is approved
            //status 3 is denied
            
            return redirect()->route('home')->with([
                'Success' => 'New vacation request successfully added',
            ]);
        }
    }

    public function showMyRequests()
    {
        $vacations = Vacation::with('users')->whereHas('users', function($query){
            $query->where('email', Auth::user()->email);
        })->paginate(10);

        return view('vacations.pendingRequests')->with([
            'vacations' => $vacations,
        ]);  
    }

    public function allVacationRequests()
    {
        $vacations = Vacation::with('users')->paginate(10);

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
        $vacations = Vacation::with('users')->where('id', $id)->get();
        
        return view('vacations.administrator.requestDetails')->with([
            'vacations' => $vacations,
        ]);
    }
}
