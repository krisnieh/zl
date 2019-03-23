<?php

namespace App\Helpers;

use App\User;

/**
 * 准备
 *
 */
class Prepare
{
    /**
     * 微信浏览器
     *
     */
    public function useWechat() 
    {
        return strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger');
    }

    /**
     * 设置cookie
     *
     */
    public function setCookie() 
    {
        $minutes = 21600; # 15天

        if($this->useWechat()) {
            if(Session::has('id') && Session::has('openid')) {
                Cookie::queue('id', session('id'), $minutes);
                // Cookie::queue('openid', session('openid'), $minutes);
            }else{
                $this->clear();
            }
        }
    }

    /**
     * 清除
     *
     */
    public function clear() 
    {
        Session::flush();
        Cookie::forget('id');
        // Cookie::forget('openid');
    }

    /**
     * 清除
     *
     */
    public function check($id) 
    {
        $res = User::find($id);

        if($res) Session::put('id', $id);

        return $res ? true : false;
    }

    /**
     * 清除
     *
     */
    public function fail() 
    {
        $a = json_decode(User::find(session('id'))->auth);

        return array_key_exists('locked', $a) && $a->locked ? true : false;
    }


    // END
}














