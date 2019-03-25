<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Cookie;
use Cache;

use App\Wechat\Oauth2;
use App\Helpers\Prepare;

class Login
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
        $auth = new Oauth2;
        $p = new Prepare;

        if ($p->useWechat()) {
            // 使用微信
            if(Session::has('id')) return $next($request);

            if(Cookie::has('id') && $p->check(Cookie::get('id')))  return $next($request);


            if(Session::has('openid')) {
                if(Cache::has(session('openid'))) return redirect('/register');
                return $next($request);
            }else{
                if(!isset($_GET['code'])) {
                    return $auth->getCode();
                }else{
                    $auth->getWebToken();
                    // $p->updateInfo();

                    return $next($request);
                }
            }

        } else {
            if(Session::has('id')) {
                return $next($request);
            } else {
                return redirect('/login');
            }
            
        }

    }
}
