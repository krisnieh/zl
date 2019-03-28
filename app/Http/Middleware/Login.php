<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Cache;
use Session;

use App\Wechat\Oauth2;
use App\Helpers\Validator;

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
        $v = new Validator;
        $wechat = new Oauth2;

        if(Auth::check()) return $next($request);

        if($v->useWechat() && Session::has('openid') && $v->regWechat(session('openid'))) {
            Auth::login($v->regWechat());
            return $next($request);
        }

        if($v->useWechat() && Session::has('openid') && !$v->regWechat(session('openid')) && Cache::has(session('openid'))) return redirect('/register');
        if($v->useWechat() && !Session::has('openid') && !isset($_GET['code'])) return $wechat->getCode();
        if($v->useWechat() && !Session::has('openid') && isset($_GET['code'])) {
            $wechat->getWebToken();
            return redirect()->back();
        } 

        return redirect('/login');

    }
}
