<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App\Wechat\Oauth2;

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

        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')) {
            // 使用微信
            if(Session::has('openid')) {
                return $next($request);
            }else{
                return $auth->getInfo();
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
