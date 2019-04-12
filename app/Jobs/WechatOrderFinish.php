<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Order;
use App\Helpers\Role;
use App\Wechat\Templet;

class WechatOrderFinish implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

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
    public function handle(Role $role, Templet $templet)
    {
        $openids = [];

        // $this->order->to->users()->where('auth->master', true)->get(); # 5.7版本不支持

        // 接收机构管理员
        foreach ($this->order->to->users as $user) {
            if($role->master($user->id) && $role->show($user->accounts, 'openid') != null) array_push($openids, $role->show($user->accounts, 'openid'));
        }

        // 机构推荐者
        if($role->show($this->order->from->orgMan->accounts, 'openid') != null) array_push($openids, $role->show($this->order->from->orgMan->accounts, 'openid'));

        // 下单者
        if($role->show($this->order->consumer->accounts, 'openid') != null) array_push($openids, $role->show($this->order->consumer->accounts, 'openid'));

        $openids = array_unique($openids);

        if(count($openids)) {
            foreach ($openids as $openid) {
                $array = [
                    'touser' => $openid,
                    'template_id' => config('wechat.templets.order_finish'),
                    'url' => config('wechat.pub.url').'/orders',
                    'data' => [
                        'first' => ['value'=>'订单已完成'],
                        'keyword1' => [
                            'value'=> $this->order->pay,
                        ],
                        'keyword2' => [
                            'value' => $this->order->goods->name . $this->order->goods->type .'×'. $this->order->num,
                        ],
                        'keyword3' => [
                            'value'=> now(),
                        ],
                        'keyword4' => [
                            'value'=> $role->show($this->order->consumer->info, 'addr'),
                        ],
                        'remark' => [
                            'value'=>'若使用了充值金额结算,请核对账户变动,谢谢!',
                        ],
                    ],
                    
                ];

                $templet->sendTemplet($array);
            }  
        }
    }

    // end
}









