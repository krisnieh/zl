<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Hash;
use Session;
use Carbon\Carbon;
use Cache;
use Auth;

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
                    ->paginate(30);

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

        $v = new Validator;
        if(!$v->checkMobile($request->mobile)) return redirect()->back()->withErrors(['mobile'=>'手机号不正确!'])->withInput();

        $exists = User::where('accounts->mobile', $request->mobile)
                        ->first();

        if(!$exists) return redirect()->back()->withErrors(['mobile'=>'手机号不存在!'])->withInput();

        if(!Hash::check($request->password, $exists->password)) return redirect()->back()->withErrors(['password'=>'密码错误!'])->withInput();

        // session(['id' => $exists->id]);

        // 微信关联
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') && Session::has('openid')) {
            Auth::login($exists, true); # 记住登录
            $exists->update(['accounts->openid' => session('openid')]);
        } else {
            Auth::login($exists);
        }

        return redirect('/apps');

    }

    // 退出
    public function logout ()
    {
        // Session::flush();
        // Cookie::forget('id');
        Auth::logout();
        return redirect('/');
    }


    // 解除微信绑定
    public function cut ()
    {
        Auth::user() -> update(['accounts->openid' => '']);
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
     * 临时: {"expire_seconds": 604800, "action_name": "QR_STR_SCENE", "action_info": {"scene": {"scene_str": "test"}}}
     *
     * 永久: {"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": 123}}}
     */
    private function setQrcode()
    {
        $qrcode = new Qrcode;

        $expire_seconds = 600; # 10分钟过期

        $json = '{"expire_seconds": '.$expire_seconds.', "action_name": "QR_STR_SCENE", "action_info": {"scene": {"scene_str": "ad_'.Auth::id().'"}}}';

        $resault = $qrcode->get($json);

        $url = $resault['url'];

        $expire = time() + $expire_seconds;

        $qrcode = ['url' => $url, 'expire' => $expire];

        $new = Auth::user()->update(['info->qrcode->url' => $url, 'info->qrcode->expire' => $expire]);

        return $qrcode;

    }

    public function ad()
    {
        // $use = Auth::user();

        $check = json_decode(Auth::user()->info);

        if(!$check || !array_key_exists('qrcode', $check) || !array_key_exists('url', $check->qrcode) || !array_key_exists('expire', $check->qrcode) || $check->qrcode->expire < time()) {
            $qrcode = $this->setQrcode();
        }else{

            $qrcode = ['url' => $check->qrcode->url, 'expire' => $check->qrcode->expire];
        }



        // $info = json_decode($use->info);


        return view('ad', compact('qrcode'));
    }


    // 注册

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
        ];

        User::create($new);

        Cache::forget(session('openid'));

        $text = '您的注册资料已经提交审核, 请耐心等待!';
        return view('note', compact('text'));
    }

    /**
     * home
     *
     */
    public function home()
    {
        $me = Auth::user();
        return view('home', compact('me'));
    }

    /**
     * 权限设置
     *
     */
    public function set($id, $key) 
    {
        $a = new Au;
        if(!$a->control($id)) abort('403');

        $target = User::findOrFail($id);
        $target->update(['auth->type' => $key]);
        return redirect()->back();
    }

    /**
     * 待审批
     *
     */
    public function approve() 
    {
        $a = new Au;
        if(!$a->manager()) abort('403');

        $records = User::whereNull('auth->type')
                ->where('id', '>', 1)
                ->paginate(30);

        return view('users', compact('records'));
    }



    // end
}



















