<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Auth;

use App\Forms\OrderForm;
use App\Product;
use App\Order;
use App\Org;
use App\Helpers\Role;

use App\Jobs\WechatOrderNew;
use App\Jobs\WechatOrderFinish;
use App\Jobs\WechatFinanceUse;

class OrderController extends Controller
{
    use FormBuilderTrait;

    /**
     * 订单列表
     *
     */
    public function index()
    {
        $org = Auth::user()->org_id;

        $r = new Role;
        if(!$r->admin()) return redirect('/orders/show/'.$org);

        $records = Order::
                    latest()
                    ->get();

        return view('orders',compact('records'));
    }

    /**
     * 单位定单
     *
     */
    public function show($org_id)
    {
        $r = new Role;
        if(!$r->admin() && !$r->inOrg($org_id)) abort('403');

        $record = Org::findOrFail($org_id);
        return view('order_show', compact('record'));
    }


    /**
     * 新订单
     *
     */
    public function new()
    {
        $r = new Role;
        if(!$r->customer() || !$r->master()) abort('403');

        $form = $this->form(OrderForm::class, [
            'method' => 'POST',
            'url' => '/orders/store'
        ]);

        $title = '江和 自补液';
        $icon = 'flask';

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

        $new = [
            'to_org' => Auth::user()->org->parent_id,
            'from_org' => Auth::user()->org->id,
            'from_user'=> Auth::id(),
        ];

        if($request->gold != 0) {
            $new['product_id'] = 1;
            $new['num'] = $request->gold;
            $order = Order::create($new);

            # 
            # 微信通知
            # 
            WechatOrderNew::dispatch($order);
        }
        if($request->black != 0) {
            $new['product_id'] = 2;
            $new['num'] = $request->black;
            $order = Order::create($new);

            # 
            # 微信通知
            # 
            WechatOrderNew::dispatch($order);
        }

        $text = '您的订单已经成功发送!';

        return view('note', compact('text'));

    }

    /**
     * 完成
     *
     */
    public function finish($id, $pay, $cut)
    {
        $target = Order::findOrFail($id);
        
        $r = new Role;
        if(!$r->inOrg($target->to_org)) abort('403');

        if(!is_numeric($pay) || $pay < 0 || $cut > $pay) {
            $color = 'danger';
            $text = '非法金额!';
            return view('note', compact('color','text'));
            exit();
        } 

        if($target->pay > 0 || $target->to_user) {
            $color = 'danger';
            $text = '此订单已经完成!';
            return view('note', compact('color','text'));
            exit();
        }

        if($cut > $target->from->give->sum('pay')) {
            $color = 'danger';
            $text = '余额不足, 请充值后重试!';
            return view('note', compact('color','text'));
            exit();
        }




        if($cut > 0) {

            $new = [
                'add' => false,
                'to_org' => Auth::user()->org_id,
                'to_user' => Auth::id(),
                'from_org' => $target->from_org,
                'from_user'=> $target->from_user,
                'pay' => - $cut,
                'state' => 1,
            ];

            $f = $target->from->give()->create($new);

            # 
            # 微信通知: 消费充值
            # 
            WechatFinanceUse::dispatch($f);
        }

        $target->update(['pay' => $pay, 'to_user' => Auth::id(), 'state' => 1]);

        # 
        # 微信通知: 完成
        # 
        WechatOrderFinish::dispatch($target);


        $text = '操作成功,订单已完成!';
        return view('note', compact('text'));
        // return redirect()->back();

    }

    /**
     * 撤销
     *
     */
    public function delete($id)
    {
        $target = Order::findOrFail($id);

        $r = new Role;
        if(!$r->inOrg($target->to_org)) abort('403');

        $target->delete();
        return redirect()->back();
    }


    /**
     * end
     *
     */
}














