<?php

namespace App\Helpers;

use Auth;

use App\User;


/**
 * 授权 
 *
 */
class Role
{
    private $auth;
    
    function __construct() 
    {
        $this->$auth = json_decode(Auth::user()->auth);
    }

    public function useWechat()
    {
        return strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger');
    }

    // END
}