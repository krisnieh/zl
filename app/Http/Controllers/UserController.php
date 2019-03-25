<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Hash;
use Session;
use Cookie;
use Carbon\Carbon;
use Cache;

use App\Forms\LoginForm;
use App\Forms\RegisterForm;
use App\User;
use App\Helpers\Au;
use App\Helpers\Validator;
use App\Wechat\Qrcode;

class UserController extends Controller
{
    use FormBuilderTrait;

    // 用户列表
    public function index ()
    {
        $records = User::where('id','>',1)
                    ->orderBy('id')
                    ->get();

        return view('users', compact('records'));
    }

    // 新用户
    public function recommend ()
    {
        # code...
    }

    // 登录
    public function login ()
    {
        $form = $this->form(LoginForm::class, [
            'method' => 'POST',
            'url' => '/check'
        ]);

        $title = '请登录';
        $icon = 'key';

        return view('form', compact('form','title','icon'));
    }

    // 登录检查
    public function check (Request $request)
    {
        $form = $this->form(LoginForm::class);

        $exists = User::where('accounts->mobile', $request->mobile)
                        ->first();

        if(!$exists) return redirect()->back()->withErrors(['mobile'=>'手机号不存在!'])->withInput();

        if(!Hash::check($request->password, $exists->password)) return redirect()->back()->withErrors(['password'=>'密码错误!'])->withInput();

        session(['id' => $exists->id]);

        // 微信关联
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') && Session::has('openid')) {
            $exists->update(['accounts->openid' => session('openid')]);
        }

        return redirect('/apps');

    }

    // 退出
    public function logout ()
    {
        Session::flush();
        Cookie::forget('id');
        return redirect('/');
    }


    // 解除微信绑定
    public function cut ()
    {
        User::find(session('id')) -> update(['accounts->openid' => '']);
        return $this->logout();
    }

    // lock 锁定
    public function lock($id)
    {
        $a = new Au;
        if(!$a->control($id)) abort('403');

        User::find($id)->update(['auth->locked' => true]);
        return redirect()->back();
    }

    // lock 解锁
    public function unlock($id)
    {
        $a = new Au;
        if(!$a->control($id)) abort('403');

        User::find($id)->update(['auth->locked' => false]);
        return redirect()->back();
    }

    /**
     * 推荐码
     *
     * 临时: {"expire_seconds": 604800, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": 123}}}
     *
     * 永久: {"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": 123}}}
     */
    private function setQrcode()
    {
        $qrcode = new Qrcode;

        $json = '{"action_name": "QR_LIMIT_STR_SCENE", "action_info": {"scene": {"scene_str": "ad_'.session('id').'"}}}';

        $resault = $qrcode->get($json);

        $url = $resault['url'];

        $new = User::find(session('id'))->update(['info->qrcode' => $url]);

        return $url;

    }

    public function ad()
    {
        $info =json_decode(User::find(session('id'))->info);

        $url = array_key_exists('qrcode', $info) ? $info->qrcode : $this->setQrcode();

        return view('ad', compact('url'));
    }

    public function register()
    {

        if(!Cache::has(session('openid')) || Session::has('id')) abort('403');

        $form = $this->form(RegisterForm::class, [
            'method' => 'POST',
            'url' => '/reg_check'
        ]);

        $title = '注册: 请在30分钟内完成';
        $icon = 'user-o';

        return view('form', compact('form','title','icon'));
    }

    /**
     * 注册检查
     *
     */
    public function regCheck(Request $request) 
    {
        $form = $this->form(RegisterForm::class);

        $v = new Validator;
        if(!$v->checkMobile($request->mobile)) return redirect()->back()->withErrors(['mobile'=>'手机号不正确!'])->withInput();

        $exists = User::where('accounts->mobile', $request->mobile)
                        ->first();

        if($exists) return redirect()->back()->withErrors(['mobile'=>'手机号已存在!'])->withInput();

        if($request->password !== $request->confirm_password) redirect()->back()->withErrors(['confirm_password'=>'密码不一致!'])->withInput();

        $array = explode('_', Cache::get(session('openid')));

        $new = [
            'parent_id' => $array[2],
            'accounts' => '{"mobile":"'.$request->mobile.'", "openid":"'.session('openid').'"}',
            'password' => bcrypt($request->password),
            'info' => '{"name":"'.$request->name.'", "addr":"'.$request->addr.'"}',
            'auth' => '{"locked":"true"}',
        ];

        User::create($new);

        Cache::forget(session('openid'));

        $text = '您的注册资料已经提交审核, 请耐心等待!';
        return view('note', compact('text'));
    }

    // end
}



















