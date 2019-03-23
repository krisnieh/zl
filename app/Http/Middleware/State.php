<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

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
        // $a = json_decode(User::find(session('id'))->auth);

        // if (array_key_exists('locked', $a) && $a->locked) {
        //     abort('403');
        // } else {    
        //     return $next($request);
        // }
    }
}
