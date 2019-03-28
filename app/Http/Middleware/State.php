<?php

namespace App\Http\Middleware;

use Closure;

use App\Helpers\Role;

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

        // if($r->locked() || $r->orgLocked()) abort('403');

        return $next($request);
        
    }
}
