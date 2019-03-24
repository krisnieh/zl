<?php

namespace App\Wechat;

use Exception;
use Request;
use Cache;
use Session;

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

        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$this->pub->app_id.'&redirect_uri='.urlencode($uri).'&response_type=code&scope='.$scop.'&state='.time().'#wechat_redirect';

        return redirect($url);
    }

    /**
     * 远程获取 web token
     *
     *
     */
    public function getWebToken() 
    {
        if(!isset($_GET['code'])) throw new Exception('微信:code未成功');

        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->pub->app_id.'&secret='.$this->pub->app_secret.'&code='.$_GET['code'].'&grant_type=authorization_code';

        $resault = $this->pub->way($url);

        Cache::put('wechat_web_token', $resault['access_token'], $resault['expires_in'] / 60);
        Cache::put('refresh_token', $resault['refresh_token'], 43200);

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
    public function refreshToken() 
    {
        if(!Cache::has('refresh_token')) abort('300');
        $url = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?appid='.$this->pub->app_id.'&grant_type=refresh_token&refresh_token='.Cache::get('refresh_token');

        $resault = $this->pub->way($url);

        Cache::put('wechat_web_token', $resault['access_token'], $resault['expires_in'] / 60);
        Cache::put('refresh_token', $resault['refresh_token'], 43200);

        // Session::put('openid', $resault['openid']);

        return $resault['access_token'];

    } 

    /**
     * web token
     *
     *
     */
    public function webToken() 
    {
        return Cache::has('wechat_web_token') ? Cache::get('wechat_web_token') : $this->refreshToken();
    }

    /**
     * 获取信息
     *
     */
    public function getInfo($openid) 
    {
        $url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$this->webToken().'&openid='.$openid.'&lang=zh_CN';
        $resault = $this->pub->way($url);
        return $resault;
    }

    // END
}
















