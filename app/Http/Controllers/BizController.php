<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use App\User;
use App\Org;
use App\Helpers\Role;

class BizController extends Controller
{
    /**
     * 审批中心
     *
     */
    public function pass() 
    {
        $r = new Role;
        if(!$r->admin() && !$r->master()) abort('403');

        $orgs = Org::where('auth->pass', 'no')
                    ->whereNull('auth->ignore')
                    ->get();

        $users = User::where('auth->pass', 'no')
                    ->whereNull('auth->ignore')
                    ->get();

        return view('pass', compact('orgs', 'users'));
    }

    /**
     * 通过
     *
     */
    public function ok($type, $id)
    {
        DB::table($type)->findOrFail($id)->update(['auth->pass' => 'yes', 'auth->locked' => false]);
        return redirect()->back();
    }


    /**
     * end
     *
     */
}















