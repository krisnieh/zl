<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Wechat\Pub;
use Input;

class WechatController extends Controller
{
    /**
     * 微信服务器认证
     *
     */
    public function ca()
    {
        $signature = Input::get('signature');
        $timestamp = Input::get('timestamp');
        $nonce     = Input::get('nonce');
        $echostr   = Input::get('echostr');

        $wechat = new Pub;
        return $wechat->ca($signature, $timestamp, $nonce, $echostr);
    }

    public function test()
    {
        $wechat = new Pub;

        echo $wechat->token();
    }

    // end
}
