<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conf extends Model
{
    protected $guarded = [];

    // 名称
    public function typeCode() 
    {
        return $this->belongsTo('App\Org', 'conf_id', 'id');
    }
}
