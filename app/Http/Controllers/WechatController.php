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

        $menu->json = '{
            "button":[
                {
                    "type":"view",
                    "name":"应用",
                    "https://zl.viirose.com/apps"
                },
                {
                    "type":"view",
                    "name":"订单",
                    "https://zl.viirose.com/orders"
                },
                {
                    "type":"view",
                    "name":"积分",
                    "https://zl.viirose.com/score"
                },
                {
                    "type":"view",
                    "name":"推荐码",
                    "https://zl.viirose.com/ad"
                }
            ]
        }';

        $menu->create();
    }

    // end
}
