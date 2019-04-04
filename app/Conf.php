<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conf extends Model
{
    protected $guarded = [];

    // 名称
    public function orgType() 
    {
        return $this->hasMany('App\Org', 'conf_id', 'id');
    }
}
