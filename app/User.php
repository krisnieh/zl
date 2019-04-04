<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $guarded = [];

    // 机构
    public function org()
    {
        // return $this->belongsTo('App\Org', 'org_id', 'id');
        return $this->hasOne('App\Org', 'id', 'org_id');
    }

    // 下家
    public function child()
    {
        return $this->hasMany('App\User', 'parent_id');
    }

    // // 订单
    // public function order()
    // {
    //     return $this->hasMany('App\Order', 'to_user_id');
    // }

    // // 业务
    // public function biz()
    // {
    //     return $this->hasMany('App\Order', 'from_user_id');
    // }

    // // 积分消费
    // public function scoreOrder()
    // {
    //     return $this->hasMany('App\Score', 'to_user_id');
    // }

    // // 积分提供
    // public function scoreBiz()
    // {
    //     return $this->hasMany('App\Score', 'from_user_id');
    // }

    // // 财务收入
    // public function income()
    // {
    //     return $this->hasMany('App\Finance', 'to_user_id');
    // }

    // // 账务支出
    // public function pay()
    // {
    //     return $this->hasMany('App\Finance', 'from_user_id');
    // }
}
