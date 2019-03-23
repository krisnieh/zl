<?php

namespace App\Wechat;

use Cache;
use Exception;
use Log;
use App\Wechat\Answer;

/**
 * 微信: 公众号
 *
 */
class Pub
{
    public $app_id, $app_secret, $token, $aes_key;

    function __construct()
    {
        $pub = config('wechat.pub');

        if(!$pub['app_id'])  throw new Exception('微信配置缺失:app_id');
        if(!$pub['app_secret'])  throw new Exception('微信配置缺失:app_secret');
        if(!$pub['token'])  throw new Exception('微信配置缺失:token');
        if(!$pub['aes_key'])  throw new Exception('微信配置缺失:aes_key');

        $this->app_id = $pub['app_id'];
        $this->app_secret = $pub['app_secret'];
        $this->token = $pub['token'];
        $this->aes_key = $pub['aes_key'];
    }

    /**
     * 远程获取 token
     * 
     * {"access_token":"ACCESS_TOKEN","expires_in":7200}
     */
    private function getToken()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$this->app_id.'&secret='.$this->app_secret;
        $resault = $this->way($url);

        Cache::put('wechat_token', $resault['access_token'], $resault['expires_in'] / 60);
        return $resault['access_token'];
    }

    /**
     * 与微信服务器交流
     *
     */
    public function way($url, $json=null)
    {
        $method = $json == null ? "GET" : "POST";

        $ch = curl_init();
        curl_setopt ($ch,CURLOPT_URL,$url);
        // curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, $method);  
        if($json !== null) curl_setopt($ch, CURLOPT_POSTFIELDS, $json); 

        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output, true);

        return $this->errorCheck($output);
    }

    /**
     * 错误处理
     *
     * {"errcode":40013,"errmsg":"invalid appid"}
     */
    private function errorCheck($array)
    {

        if(array_key_exists("errcode", $array) && $array['errcode'] != 0) {
            $errmsg = array_key_exists('errmsg', $array) ? $array['errmsg'] : '';
            throw new Exception('微信返回错误:'.$array['errcode'].$errmsg);
        }

        return $array;
    }

    /**
     * cache 读取token
     *
     */
    public function token()
    {
        return Cache::has('wechat_token') ? Cache::get('wechat_token') : $this->getToken();
    }

    /**
     * 签名生成
     *
     */
    private function makeSignature($timestamp,$nonce) 
    {
        $arr = array($this->token, $timestamp, $nonce);
        sort($arr, SORT_STRING);
        return sha1(implode($arr));
    }

    /**
     * 微信服务器认证
     *
     */
    public function ca() 
    {
        $xml = file_get_contents('php://input');

        if($xml) {
            $a = new Answer;
            return $a->router(xml_to_array($xml));
        }elseif(isset($_GET['signature']) && isset($_GET['timestamp']) && isset($_GET['nonce']) && isset($_GET['echostr'])){
            return $this->shakeHands();
        }
    }

    /**
     * 握手
     *
     */
    private function shakeHands() 
    {
        $signature = $_GET['signature'];
        $timestamp = $_GET['timestamp'];
        $nonce     = $_GET['nonce'];
        $echostr   = $_GET['echostr'];

        $dev_signature = $this->makeSignature($timestamp,$nonce);
        if($dev_signature == $signature) return $echostr;
    }

}
















