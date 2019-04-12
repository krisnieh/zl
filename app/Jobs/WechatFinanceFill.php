<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Finance;
use App\Helpers\Role;
use App\Wechat\Templet;

class WechatFinanceFill implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $finance;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Finance $finance)
    {
        $this->finance = $finance;

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
        foreach ($this->finance->to->users as $user) {
            if($role->master($user->id) && $role->show($user->accounts, 'openid') != null) array_push($openids, $role->show($user->accounts, 'openid'));
        }

        if($role->show($this->finance->from->orgMan->accounts, 'openid') != null) array_push($openids, $role->show($this->finance->from->orgMan->accounts, 'openid'));

        // 充值者
        if($role->show($this->finance->consumer->accounts, 'openid') != null) array_push($openids, $role->show($this->finance->consumer->accounts, 'openid'));

        $openids = array_unique($openids);

        if(count($openids)) {
            foreach ($openids as $openid) {
                $array = [
                    'touser' => $openid,
                    'template_id' => config('wechat.templets.finance_fill'),
                    // 'url' => config('wechat.pub.url').'/orders/show/'.$this->finance->to_org,
                    'data' => [
                        'first' => ['value'=>'充值成功通知'],
                        'keyword1' => [
                            'value'=> $this->finance->from->name .'-'. $role->show($this->finance->consumer->info, 'name') . $role->show($this->finance->consumer->accounts, 'mobile'),
                        ],
                        'keyword2' => [
                            'value' => $this->finance->pay,
                            'color' => '#18A304',
                        ],
                        'keyword3' => [
                            'value'=> date("Y-m-d h:i:s", time()),
                        ],
                        'remark' => [
                            'value'=>'若有疑问请立即联系代理商',
                        ],
                    ],
                    
                ];

                $templet->sendTemplet($array);
            }  
        }
    }

    // end
}














