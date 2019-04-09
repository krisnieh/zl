<?php

namespace App\Http\Middleware;

use Closure;

use App\Helpers\Role;
use App\Auth;

class State
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
        $r = new Role;

        if(!Auth::check()) abort('403');
        if($r->locked() || $r->orgLocked()) abort('403');

        return $next($request);
        
    }
}
