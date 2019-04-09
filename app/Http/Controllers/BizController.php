<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

use App\User;
use App\Org;
use App\Helpers\Role;

class BizController extends Controller
{
    private $au;
    /**
     * 审批中心
     *
     */
    public function pass() 
    {
        $r = new Role;
        if(!$r->admin() && !$r->master()) abort('403');

        $this->au = new Role;

        $orgs = Org::where('auth->pass', 'no')
                    ->where(function ($query) {

                        if(!$this->au->admin()){
                            $query->Where('parent_id', Auth::user()->org_id);
                        }

                    })
                    ->whereNull('auth->ignore')
                    ->get();

        $users = User::where('auth->pass', 'no')
                    ->where(function ($query) {

                        if(!$this->au->admin()){
                            $query->Where('parent_id', Auth::user()->org_id);
                        }

                    })
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
        $r = new Role;
        if(!$r->admin() && !$r->master()) abort('403');
        
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

        return redirect()->back();
    }


    /**
     * end
     *
     */
}















