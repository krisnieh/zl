<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use URL;

use App\Wechat\Pub;
use App\Wechat\Menu;
use App\Wechat\Templets;

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
     * 操作
     *
     */
    public function answer() 
    {
        $xml = file_get_contents('php://input');
        $array = xml_to_array($xml);

        $t = new Templets;

        switch ($array['Event']) {
            case 'subscribe':
                # 订阅
                $news =[
                    'OpenID' => $array['FromUserName'], 
                    'Articles' => [
                       ['title'=>'众乐速配', 'description'=>'快捷.高效', 'picurl'=>URL::asset('image/welcome.jpg'), 'url'=>'https://zl.viirose.com'],
                    ],
                ];

                echo($t->news($news));

                break;
            
            default:
                # code...
                break;
        }
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
                    "name":"推荐码",
                    "url":"https://zl.viirose.com/ad"
                },
                {
                    "type":"view",
                    "name":"积分",
                    "url":"https://zl.viirose.com/score"
                },
                {
                    "type":"view",
                    "name":"应用",
                    "url":"https://zl.viirose.com/apps"
                } 
            ]
        }';

        $menu->create($json);

        return view('ok');
    }

    /**
     * 删除菜单
     *
     */
    public function menuDelete()
    {
        $menu = new Menu;
        $menu->delete();

        return view('ok');
    }


    /**
     * End
     *
     */
}














