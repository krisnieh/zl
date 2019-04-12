<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use URL;
use Log;

use App\Order;
use App\Wechat\Templet;
use App\Wechat\Pub;
use App\Helpers\Role;

class WechatTemplet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Templet $templet, Role, $role)
    {
        $openids = [];

        // $order->to->users()->where('auth->master', true)->get(); # 5.7版本不支持

        // 接收机构管理员
        foreach ($order->to->users as $user) {
            if($role->master($user->id) && $role->show($user->accounts, 'openid')) array_push($openids, $role->show($user->accounts, 'openid'));
        }

        if($role->show($order->from->orgMan->accounts, 'openid')) array_push($openids, $role->show($order->from->orgMan->accounts, 'openid'));

        array_unique($openid);

        if(count($openids)) {
            foreach ($openids as $openid) {
                $array = [
                    'openid' => $openid,
                    'template_id' => config('wechat.templets.order_new'),
                    'url' => URL::asset('/orders/show/'.$this->order->from->id),
                    'first' => '新订单通知',
                    'remark' => '请及时与订货人联系确认',
                    'keywords' => [
                        $this->order->pay, # '订单金额',
                        $this->order->goods->name . $this->order->goods->type .'×'. $this->order->num, #'订单详情',
                        $this->order->id # '订单号',
                        $this->order->from->name . $role->show($this->order->from_user->accounts, 'mobile') # '买家会员',
                    ],
                ];
                // 发送
                Log::warning($array);
            }  
        }


    }

    // end
}




















