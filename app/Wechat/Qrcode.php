<?php

namespace App\Wechat;

use App\Wechat\Pub;


/**
 * 二维码
 *
 */
class Qrcode
{
    
    private $pub;
    private $url;

    function __construct()
    {
        $this->pub = new Pub;
        $this->url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$this->pub->token();
    }

    /**
     * 二维码
     *
     * 临时: {"expire_seconds": 604800, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": 123}}}
     *
     * 永久: {"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": 123}}}
     */
    public function get($json)
    {
        return $this->pub->way($this->url, $json);
    }



    // END
}