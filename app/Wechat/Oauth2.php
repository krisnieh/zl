<?php

namespace App\Wechat;

use Exception;
use Request;

use App\Wechat\Pub;

/**
 * 网页授权
 *
 */
class Oauth2 
{
    private $pub;

    function __construct()
    {
        $this->pub = new Pub;
    }

    /**
     * 获取 code
     *
     *
     */
    public function getCode($scop="snsapi_base") 
    {
        $uri = Request::fullUrl();

        if($scop != "snsapi_userinfo" && $scop != "snsapi_base") throw new Exception('微信scop错误');

        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$pub->app_id.'&redirect_uri='.urlencode($uri).'&response_type=code&scope='.$scop.'&state=STATE#wechat_redirect';

        return redirect($url);
    }

    /**
     * 远程获取 web token
     *
     *
     */
    public function getWebToken() 
    {
        if(!isset($_GET['code'])) return $this->getCode();

        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$pub->app_id.'&secret='.$pub->app_secret.'&code='.$_GET['code'].'&grant_type=authorization_code';

        $resault = $pub->way($url);

        Cache::put('wechat_web_token', $resault['access_token'], $resault['expires_in'] / 60);
        Session::put('openid', $resault['openid']);

        return $resault['access_token'];
    }

    /**
     * opeid 
     *
     *
     */
    public function openid() 
    {
        return Session::has('openid') ? Session::get('openid') : $this->getWebToken();
    } 

    /**
     * web token
     *
     *
     */
    public function webToken() 
    {
        return Cache::has('wechat_web_token') ? Cache::get('wechat_web_token') : $this->getWebToken();
    }

    /**
     * 获取信息
     *
     */
    public function getInfo() 
    {
        $url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$this->webToken().'&openid='.$this->openid.'&lang=zh_CN';
        $resault = $pub->way($url);
        return $resault;
    }

    // END
}
















