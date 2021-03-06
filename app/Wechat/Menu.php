<?php

namespace App\Wechat;

use App\Wechat\Pub;

/**
 * 微信菜单
 *
 */
class Menu
{
    private $pub;

    function __construct()
    {
        $this->pub = new Pub;
    }

    /**
     * 新建
     *
     */
    public function create($json)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$this->pub->token();
        return $this->pub->way($url, $json);
    }

    /**
     * 删除
     *
     */
    public function delete()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/delete?access_token='.$this->pub->token();
        return $this->pub->way($url);
    }
}