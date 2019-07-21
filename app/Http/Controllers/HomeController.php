<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\UserRoles;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
use App\Models\Vacation;
use App\Classes\VacationQuerys;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

     public function index()
     {
        $user = User::where('email',Auth::user()->email)->first();

        if(UserRoles::check() === Role::ADMIN){
            $requestsWaiting = VacationQuerys::adminVacationRequests();
        }

        if(UserRoles::check() === Role::APPROVER){
            $requestsWaiting = VacationQuerys::approverVacationRequests();
        }

        if(UserRoles::check() === Role::EMPLOYEE){
            $requestsWaiting =  Vacation::where([
                'user_id' => Auth::user()->id,
                'status' => Vacation::PENDING,
            ])->get();    
        }
    
        return view('home')->with([
            'role' => UserRoles::check(),
            'user' => $user,
            'requestWaitingCount' => count($requestsWaiting),
            'requestsWaiting' => $requestsWaiting,
        ]);
     }
}
