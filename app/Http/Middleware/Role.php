<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (!Sentinel::check()){
            return redirect()->route('user.login');
        }

        $role_id = Sentinel::getUser()->roleId;

        if( in_array($role_id, [1,2] ) ){
            return $next($request);
        }

        return redirect('/merchant-dashboard');

    }
}
