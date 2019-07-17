<?php

namespace App\Http\Middleware;

use Closure;
use App\Classes\UserRoles;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,...$roles)
    {
        foreach ($roles as $role) {
            if(UserRoles::check() === $role){
                return $next($request); 
            }
        }
        return redirect()->route('home');
    }
}
