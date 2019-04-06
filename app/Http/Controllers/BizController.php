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
        switch ($type) {
            case 'orgs':
                Org::findOrFail($id)->update(['auth->locked' => false, 'auth->pass' => 'yes']);
                break;

            case 'users':
                User::findOrFail($id)->update(['auth->locked' => false, 'auth->pass' => 'yes']);
                break;
            
            default:
                abort('403');
                break;
        }

        // $target = DB::table($type)->find($id);
        // $target->update(['auth->locked' => false, 'auth->pass' => 'yes']);
        return redirect()->back();
    }


    /**
     * end
     *
     */
}















