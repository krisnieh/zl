<?php

namespace App\Helpers;

use App\User;
use App\Wechat\Oauth2;

use Cookie;
use Session;

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
     * 用户信息
     *
     */
    public function me() 
    {
        $me = User::find(session('id'))->info;
        return json_decode($me);
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

        $ex = User::find(session('id'));

        if(!$ex) {
            if(Cookie::has('id')) Cookie::forget('id');
            if(Session::has('id')) Session::forget('id');
            return false;
        }

        $a = json_decode($ex->auth);

        return (array_key_exists('locked', $a) && $a->locked) || !array_key_exists('type', $a) ? true : false;
    }

    /**
     * 更新信息
     *
     */
    public function updateInfo() 
    {

        $auth = new Oauth2;
        $openid = session('openid');

        $info = $auth->getInfo($openid);

        $me = User::find(session('id'));
            
        $me->update(['info->wechat' => json_encode($info)]);
        // $me->update(['info->wechat', ])
    }

    /**
     * 显示json
     *
     */
    public function show($json, $item, $default=null)
    {
        $array = json_decode($json);
        return array_key_exists($item, $array) ? $array->$item : $default;
    }


    // END
}














