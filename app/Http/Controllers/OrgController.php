<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

use App\Org;
use App\Conf;
use App\Helpers\Role;

class OrgController extends Controller
{
    private $role;

    public function index()
    {
        $this->role = new Role;

        $records = Conf::where('type','org')

                        ->with(['orgType' => function ($query) {
                            if(!$this->role->admin()) {
                                $query->where('id', Auth::user()->org_id);
                                $query->orWhere('parent_id', Auth::user()->org_id);
                                // $query->orWhereHas('typeConf', function ($query) {
                                //     $query->where('order', '>', Auth::user()->org->typeConf->order);
                                // });
                            }
                        }])

                        ->where('key', '<>', 'invalid')
                        ->where('key', '<>', 'root')
                        ->where('active', true)
                        ->orderBy('order')
                        ->get();

        return view('orgs', compact('records'));
    }


    // lock 锁定
    public function lock($id)
    {
        $r = new Role;
        if(!$r->admin()) abort('403');

        Org::findOrFail($id)->update(['auth->locked' => true]);
        return redirect()->back();
    }

    // lock 解锁
    public function unlock($id)
    {
        $r = new Role;
        if(!$r->admin()) abort('403');

        Org::findOrFail($id)->update(['auth->locked' => false]);
        return redirect()->back();
    }

    // 显示
    public function show($id)
    {
        $r = new Role;
        if(!$r->admin() && !$r->orgMaster($id) && $r->inOrg($id)) abort('403');

        $record = Org::findOrFail($id);

        return view('org_show', compact('record'));
    }

    // END
}





















