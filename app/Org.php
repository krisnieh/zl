<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Org extends Model
{
    protected $guarded = [];

    // 员工和客户
    public function users()
    {
        return $this->hasMany('App\User', 'org_id');
    }

    // 老板
    public function boss()
    {
        return $this->hasOne('App\User', 'boss_id');
    }

    // 管理者
    public function master()
    {
        return $this->hasOne('App\User', 'master_id');
    }

}
