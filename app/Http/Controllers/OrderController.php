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

        $title = '江河 自补液';
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
            Order::create($new);
        }
        if($request->black != 0) {
            $new['product_id'] = 2;
            $new['num'] = $request->black;
            Order::create($new);
        }

        $text = '您的订单已经成功发送!';

        # 
        # 微信通知
        # ---------
        # 

        return view('note', compact('text'));

    }

    /**
     * 完成
     *
     */
    public function finish($id, $price)
    {
        echo $id;
        echo $price;
        // $target = Order::findOrFail($id);

        // $r = new Role;
        // if(!$r->inOrg($target->to_org)) abort('403');

        // $target->delete();
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














