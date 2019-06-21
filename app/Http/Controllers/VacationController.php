<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Vacation;

class VacationController extends Controller
{
    public function create(Request $request)
    {
        $today = date('m/d/Y');
        
        if(strtotime($today) > strtotime($request->from)){
            return redirect()->back()->with([
                'Error' => "Please chose date after $today ",
            ]);

        }else{
            $currentUserId = Auth::user()->id;
        
            Vacation::create([
                'from' => $request->from,
                'to' => $request->to,
                'users_id' => $currentUserId,
            ]);
            
            return redirect()->route('home')->with([
                'Success' => 'New vacation request successfully added',
            ]);
        }
    }

    public function show()
    {
        return view('vacations.pendingRequests');  
    }
}
