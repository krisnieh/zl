<?php

namespace App\Wechat;

use App\Wechat\Pub;


/**
 * 二维码
 *
 */
class Templet
{
    private $pub;
    private $url;

    function __construct()
    {
        $this->pub = new Pub;
        $this->url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->pub->token();
    }

    /**
     * 模板消息
     *
       $array = [
            'openid' => ,
            'template_id' => ,
            'url' => ,
            'first' => '店铺新订单成交通知',
            'remark' => '该张订单完成后，店铺提成可以在会员中心申请提现',
            'keywords' => [
                '订单金额',
                '订单详情',
                '订单号',
                '买家会员',
            ],
        ];
     */
    public function sendTemplet($array)
    {
        $keywords = '';

        for ($i=1; $i <= count($array['keywords']) ; $i++) { 
            $keywords .= '
                "keyword'.$i.'":{
                   "value":"'.$array['keywords'][$i].'"
                },
            ';
        }

        $json = '
        {
           "touser":"'.$array['openid'].'",
           "template_id":"'.$array['template_id'].'",
           "url":"'.$array['url'].'",           
           "data":{
                    "first": {
                       "value":"'.$array['first'].'"
                    },
                    '.$keywords.'
                    "remark":{
                       "value":"'.$array['remark'].'",
                    }
           }
       }';

       return $this->pub->way($this->url, $json);
    }

    /**
     * 
     *
     */
}























