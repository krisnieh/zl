<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Wechat\Pub;
use App\Wechat\Menu;

class WechatController extends Controller
{
    /**
     * 微信服务器认证
     *
     */
    public function ca()
    {
        $wechat = new Pub;
        echo($wechat->ca());
    }

    public function menuCreate()
    {
        $menu = new Menu;

        $json = '{
            "button":[
                {
                    "type":"view",
                    "name":"应用",
                    "url":"https://zl.viirose.com/apps"
                },
                {
                    "type":"view",
                    "name":"订单",
                    "url":"https://zl.viirose.com/orders"
                },
                {
                    "type":"view",
                    "name":"积分",
                    "url":"https://zl.viirose.com/score"
                },
                {
                    "type":"view",
                    "name":"推荐码",
                    "url":"https://zl.viirose.com/ad"
                }
            ]
        }';

        $menu->create($json);
    }

    // end
}
