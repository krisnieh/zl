<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Wechat Public
    |--------------------------------------------------------------------------
    |
    |
    */


    'pub' => [
        'url' =>  env('APP_URL', false),
        'app_id' => env('WECHAT_APP_ID', false),
        'app_secret' => env('WECHAT_SECRET', false),
        'token' => env('WECHAT_TOKEN', false),
        'aes_key' => env('WECHAT_AES_KEY', false),
        'name' => env('WECHAT_NAME', false),
    ],

    'templets' => [
        'finance_fill' => env('WECHAT_TEMPLET_FINANCE_FILL', false),
        'finance_use' => env('WECHAT_TEMPLET_FINANCE_USE', false),
        'order_new' => env('WECHAT_TEMPLET_ORDER_NEW', false),
        'order_finish' => env('WECHAT_TEMPLET_ORDER_FINISH', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Wechat Enterprise
    |--------------------------------------------------------------------------
    |
    |
    */
    'enterprise' => [
        // 
    ],


];
