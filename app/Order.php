<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];
    
    // 消费者
    public function consumer()
    {
        return $this->belongsTo('App\User', 'to_user_id');
    }

    // 商家
    public function seller()
    {
        return $this->belongsTo('App\User', 'from_user_id');
    }
}
