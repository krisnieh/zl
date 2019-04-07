<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];
    
    // 订货
    public function from()
    {
        return $this->hasOne('App\Org', 'id', 'from_org');
    }

    // 发货
    public function to()
    {
        return $this->hasOne('App\Org', 'id', 'to_org');
    }

    // 消费者
    public function consumer()
    {
        return $this->hasOne('App\User', 'id', 'from_user');
    }

    // 商家
    public function seller()
    {
        return $this->hasOne('App\User', 'id', 'to_user');
    }

    // goods
    public function goods()
    {
        return $this->hasOne('App\Product', 'id', 'product_id');
    }
}
