<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    protected $guarded = [];
    
    // 消费者
    public function toUser()
    {
        return $this->belongsTo('App\User', 'to_user_id');
    }

    // 商家
    public function fromUser()
    {
        return $this->belongsTo('App\User', 'from_user_id');
    }
}
