<?php

namespace App\Wechat;

use App\Wechat\Pub;

/**
 * 微信菜单
 *
 */
class Menu
{
    public $json;

    private $pub;

    function __construct()
    {
        $this->pub = new Pub;
    }

    /**
     * 新建
     *
     */
    public function create()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$this->pub->token();
        return $this->pub->way($url, $this->json);
    }
}