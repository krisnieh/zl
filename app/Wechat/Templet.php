<?php

namespace App\Wechat;

use Log;

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
          'touser' => $openid,
          'template_id' => config('wechat.templets.order_new'),
          'url' => config('wechat.pub.url').'/orders/show/'.$this->order->from->id,
          'data' => [
              'first' => ['value'=>'新订单通知'],
              'keyword1' => [
                  'value'=>'待确认',
              ],
              'keyword2' => [
                  'value' => $this->order->goods->name . $this->order->goods->type .'×'. $this->order->num,
              ],
              'keyword3' => [
                  'value'=>$this->order->id,
              ],
              'keyword4' => [
                  'value'=>$this->order->from->name .'-'. $role->show($this->order->consumer->info, 'name') . $role->show($this->order->consumer->accounts, 'mobile'),
              ],
              'remark' => [
                  'value'=>'请及时与订货人联系确认',
              ],
          ],
          
      ];
     */
    public function sendTemplet($array)
    {
      $json = json_encode($array);
      return $this->pub->way($this->url, $json);
    }

    /**
     * 
     *
     */
}























