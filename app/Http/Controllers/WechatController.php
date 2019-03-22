<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Wechat\Pub;

class WechatController extends Controller
{
    /**
     * 微信服务器认证
     *
     */
    public function ca()
    {
        $wechat = new Pub;
        return $wechat->token();
    }

    public function test()
    {
        $wechat = new Pub;

        echo $wechat->token();
    }

    // end
}
