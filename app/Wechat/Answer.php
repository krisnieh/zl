<?php

namespace App\Wechat;

use App\Wechat\Templets;
use URL;

/**
 * 自动应答
 *
 */
class Answer
{
    
    /**
     * 操作
     *
     */
    private function router($array) 
    {
        $t = new Templets;

        switch ($array['Event']) {
            case 'subscribe':
                # 订阅
                $arr =[
                    'OpenID' => $array['FromUserName'], 
                    'Articles' => [
                       ['title'=>'众乐速配', 'description'=>'快捷.高效', 'picurl'=>URL::asset('image/welcome.jpg'), 'url'=>'https://zl.viirose.com'],
                    ],
                ];

                echo($t->news($arr));

                break;
            
            default:
                # code...
                break;
        }
    }

    // END
}















