<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Auth;

use App\Finance;
use App\Org;
use App\Helpers\Role;
use App\Forms\FinanceForm;
use App\Wechat\Templet;

class FinanceController extends Controller
{
    
    use FormBuilderTrait;

    /**
     * 充值列表
     *
     */
    public function index()
    {
        $org = Auth::user()->org_id;

        $r = new Role;
        if(!$r->admin()) return redirect('/finance/show/'.$org);

        $records = Finance::
                    latest()
                    ->get();

        return view('finance',compact('records'));
    }

    /**
     * 单位财务记录
     *
     */
    public function show($org_id)
    {
        $r = new Role;
        if(!$r->admin() && !$r->inOrg($org_id)) abort('403');

        $record = Org::findOrFail($org_id);
        // $record = Org::where('id', $org_id)
        //                 ->with(['give' => function ($query) {
        //                     $query->orderBy('created_at', 'desc');
        //                 }])
        //                 ->first();

        return view('finance_show', compact('record'));
    }


    /**
     * 新订单
     *
     */
    public function new()
    {
        $r = new Role;
        if(!$r->customer() || !$r->master()) abort('403');

        $form = $this->form(FinanceForm::class, [
            'method' => 'POST',
            'url' => '/finance/store'
        ]);

        $title = '充值';
        $icon = 'jpy';

        return view('form', compact('form','title','icon'));
    }

    /**
     * 保存
     *
     */
    public function store(Request $request)
    {
        $r = new Role;
        if(!$r->customer() || !$r->master()) abort('403');



        if($request->pay < 100 || $request->pay > 5000) {
            $color = 'danger';
            $text = '此订单已经完成!';
            return view('note', compact('color','text'));
            exit();
        }

        $new = [
            'add' => true,
            'to_org' => Auth::user()->org->parent_id,
            'from_org' => Auth::user()->org->id,
            'from_user'=> Auth::id(),
            'pay' => $request->pay,
        ];

        Finance::create($new);

        $text = '您的充值已经成功提交,正等待代理商确认';

        # 
        # 微信通知
        # ---------
        # 

        return view('note', compact('text'));

    }

    /**
     * 确认充值
     *
     */
    public function finish($id, $month, $vip)
    {
        $target = Finance::findOrFail($id);
        
        $r = new Role;
        if(!$r->inOrg($target->to_org) && !$r->master()) abort('403');

        if($target->state > 0 || $target->to_user) {
            $color = 'danger';
            $text = '此充值已经确认!';
            return view('note', compact('color','text'));
            exit();
        }

        if($month > 24 || $month < 1) {
            $color = 'danger';
            $text = '充值有效期必须1至24个月之间';
            return view('note', compact('color','text'));
            exit();
        }


        $target->update(['month' => $month, 'to_user' => Auth::id(), 'state' => 1]);

        $customer_org = Org::findOrFail($target->from_org);

        switch (intval($vip)) {
            case 1:
                $customer_org->update(['auth->vip' => '白银']);
                break;
            case 2:
                $customer_org->update(['auth->vip' => '黄金']);
                break;
            case 3:
                $customer_org->update(['auth->vip' => '钻石']);
                break;
            
            default:
                # code...
                break;
        }

        $text = '操作成功,充值已确认!';
        return view('note', compact('text'));

    }

    /**
     * 撤销
     *
     */
    public function delete($id)
    {
        $target = Finance::findOrFail($id);

        $r = new Role;
        if(!$r->orgMaster($target->to_org) && !$r->own($target->from_user)) abort('403');

        $target->delete();
        return redirect()->back();
    }


    /**
     * end
     *
     */
}
