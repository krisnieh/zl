<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use URL;
use Log;
use Cache;

use App\Wechat\Pub;
use App\Wechat\Menu;
use App\Wechat\Templets;
use App\User;

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
        
        if(!$xml) {
            echo "success";
            exit();
        }

        $array = xml_to_array($xml);
        Log::info($array);

        $t = new Templets;

        switch ($array['Event']) {
            case 'subscribe':
                # 订阅
                $news =[
                    'OpenID' => $array['FromUserName'], 
                    'Articles' => [
                        [
                            'title'=>"众乐速配", 
                            'description'=>"欢迎关注众乐速配-江和自补液。江和携手经销商，助您2019生意腾飞!", 
                            'picurl'=>URL::asset('image/welcome.jpg'), 
                            'url'=>"https://zl.viirose.com",
                        ],
                    ],
                ];
                // Log::info($array);

                // 推荐码
                $ex = User::where('accounts->openid', $array['FromUserName'])->first();

                if(!$ex && array_key_exists('EventKey', $array)) Cache::put($array['FromUserName'], $array['EventKey'], 30);

                // 回复
                echo($t->news($news));

                break;
            
            default:
                echo "success";
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
                    "name":"订单",
                    "url":"https://zl.viirose.com/orders"
                },
                {
                    "type":"view",
                    "name":"应用",
                    "url":"https://zl.viirose.com/apps"
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


    /**
     * End
     *
     */
}














