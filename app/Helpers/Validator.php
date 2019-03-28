<?php
namespace App\Helpers;

use App\User;
use Auth;

 class Validator
 {
    // 使用微信
    public function useWechat()
    {
        return strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger');
    }

    // 微信登录
    public function regWechat($openid)
    {
        $has = User::where('accounts->openid', $openid)->first();

        if($has) Auth::login($has);

        return $has ? $has : false;
    }
    
    // 18位身份证
    public function checkIdNumber($val)
    {
        $rule='/^\d{6}(18|19|20)?\d{2}(0[1-9]|1[012])(0[1-9]|[12]\d|3[01])\d{3}(\d|[xX])$/';
        return preg_match($rule,$val) ? true : false;
    }

    // 手机号
    public function checkMobile($val)
    {
        $rule = '/^1[3456789]{1}\d{9}$/';
        return preg_match($rule,$val) ? true : false;
    }


 }