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
        'app_id' => env('WECHAT_APP_ID', false),
        'app_secret' => env('WECHAT_SECRET', false),
        'token' => env('WECHAT_TOKEN', false),
        'aes_key' => env('WECHAT_AES_KEY', false),
        'name' => env('WECHAT_NAME', false),
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