<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Hash;
use Session;
use Cookie;
use Carbon\Carbon;

use App\Forms\LoginForm;
use App\User;
use App\Helpers\Au;
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

        return redirect('/home');

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

    // end
}



















