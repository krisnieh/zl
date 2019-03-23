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
        if(Session::has('id')) {
            // 已登录
            $a = json_decode(User::find(session('id'))->auth);

            if (array_key_exists('locked', $a) && $a->locked) {
                abort('403');
            } else {    
                return $next($request);
            }

        } else {
            if(Session::has('openid')){
                $has = User::where('accounts->openid', session('openid'))->first();
                if($has) {
                    Session::put('id', $has->id);
                    return $next($request);
                }else{
                    abort('403');
                }
            }else{
                Session::flush();
            }
        }
        
    }
}
