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

    // 给钱
    public function give()
    {
        return $this->hasMany('App\Finance', 'from_org', 'id');
    }

    // 收钱
    public function accept()
    {
        return $this->hasMany('App\Finance', 'to_org', 'id');
    }

}
