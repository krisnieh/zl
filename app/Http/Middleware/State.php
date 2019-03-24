<?php

namespace App\Http\Middleware;

use Closure;
use Session;

use App\Helpers\Prepare;
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
        $p = new Prepare;

        if(Session::has('id')) {
            // 已登录
            if($p->fail()) abort('403');

            return $next($request);

        } else {
            if(Session::has('openid')){
                $has = User::where('accounts->openid', session('openid'))->first();
                if($has) {
                    Session::put('id', $has->id);
            // $p->updateInfo();
                    if($p->fail()) abort('403');

                    return $next($request);
                }else{
                    // abort('400');
                    return redirect('/login');
                }
            }else{
                Session::flush();
            }
        }
        
    }
}
