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
    public function handle(Role $role)
    {
        $openids = [];
        Log::info('handle');

        // $this->order->to->users()->where('auth->master', true)->get(); # 5.7版本不支持

        // 接收机构管理员
        foreach ($this->order->to->users as $user) {
            if($role->master($user->id) && $role->show($user->accounts, 'openid') != null) array_push($openids, $role->show($user->accounts, 'openid'));
        }

        if($role->show($this->order->from->orgMan->accounts, 'openid') != null) array_push($openids, $role->show($this->order->from->orgMan->accounts, 'openid'));

        // array_unique($openids);
        Log::info($openids);

        if(count($openids)) {
            foreach ($openids as $openid) {
                $array = [
                    'openid' => $openid,
                    'template_id' => config('wechat.templets.order_new'),
                    'url' => URL::asset('/orders/show/'.$this->order->from->id),
                    'first' => '新订单通知',
                    'remark' => '请及时与订货人联系确认',
                    'keywords' => [
                        '待确认', # '订单金额',
                        $this->order->goods->name . $this->order->goods->type .'×'. $this->order->num, #'订单详情',
                        $this->order->id, # '订单号',
                        $this->order->from->name .'-'. $role->show($this->order->consumer->info 'name') . $role->show($this->order->consumer->accounts, 'mobile'), # '买家会员',
                    ],
                ];
                // 发送
                Log::info($array);
            }  
        }
    }
}
