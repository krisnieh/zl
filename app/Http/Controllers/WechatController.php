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

    /**
     * 新建菜单
     *
     */
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

    /**
     * 删除菜单
     *
     */
    public function menuDelete()
    {
        $menu = new Menu;
        $menu->delete();
    }
    // end
}














