<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Org extends Model
{
    protected $guarded = [];

    // 老板
    public function typeConf()
    {
        return $this->hasOne('App\Conf', 'id', 'conf_id');
    }

    // 员工和客户
    public function users() 
    {
        return $this->hasMany('App\User', 'org_id', 'id');
    }

    // 花费
    public function costs()
    {
        return $this->hasMany('App\Order', 'from_org', 'id');
    }

    // 卖货
    public function sales()
    {
        return $this->hasMany('App\Order', 'to_org', 'id');
    }

    // // 管理者
    // public function master()
    // {
    //     return $this->hasOne('App\User', 'master_id');
    // }

}
