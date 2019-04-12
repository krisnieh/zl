<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Log;
use URL;

use App\Order;
use App\Helpers\Role;
use App\Wechat\Templet;

class WechatOrderNew implements ShouldQueue
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

        if($role->show($this->order->from->orgMan->accounts, 'openid') != null) array_push($openids, $role->show($this->order->from->orgMan->accounts, 'openid'));

        $openids = array_unique($openids);

        if(count($openids)) {
            foreach ($openids as $openid) {
                $array = [
                    'touser' => $openid,
                    'template_id' => config('wechat.templets.order_new'),
                    'url' => config('wechat.pub.url').'/orders/show/'.$this->order->to_org,
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

                $templet->sendTemplet($array);
            }  
        }
    }
}
