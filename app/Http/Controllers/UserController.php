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
use App\Org;
use App\Conf;

use App\Helpers\Role;
use App\Helpers\Validator;
use App\Wechat\Qrcode;

class UserController extends Controller
{
    use FormBuilderTrait;

    // 用户列表
    public function index ()
    {
        $records = User::where('id','>',1)
                    ->where('org_id', Auth::user()->org_id)
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
        $r = new Role;
        if(!$r->higher($id)) abort('403');

        User::findOrFail($id)->update(['auth->locked' => true]);
        return redirect()->back();
    }

    // lock 解锁
    public function unlock($id)
    {
        $r = new Role;
        if(!$r->higher($id)) abort('403');

        User::findOrFail($id)->update(['auth->locked' => false]);
        return redirect()->back();
    }

    /**
     * 个人详情
     *
     *
     */
    public function show($id=0)
    {
        $r = new Role;
        if(!$r->higher($id)) abort('403');

        $record = $id == 0 ? Auth::user() : User::findOrFail($id);
        
        return view('show', compact('record'));
    }

    /**
     * 微信二维码
     *
     * 临时: {"expire_seconds": 604800, "action_name": "QR_STR_SCENE", "action_info": {"scene": {"scene_str": "test"}}}
     *
     * 永久: {"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": 123}}}
     */
    private function setQrcode($key)
    {
        $qrcode = new Qrcode;

        $expire_seconds = 600; # 10分钟过期

        $json = '{"expire_seconds": '.$expire_seconds.', "action_name": "QR_STR_SCENE", "action_info": {"scene": {"scene_str": "ad_'.Auth::id().'_'.$key.'"}}}';

        $resault = $qrcode->get($json);

        $url = $resault['url'];

        $expire = time() + $expire_seconds;

        Auth::user()->update(['info->qrcode->'.$key.'->url' => $url, 'info->qrcode->'.$key.'->expire' => $expire]);

    }

    /**
     * 二维码: 数据库信息是否过期
     *
     */
    private function checkQrcode($key)
    {
        $check = json_decode(Auth::user()->info);

        if(!$check || !array_key_exists('qrcode', $check) || !array_key_exists($key, $check->qrcode) || !array_key_exists('url', $check->qrcode->$key) || !array_key_exists('expire', $check->qrcode->$key) || $check->qrcode->$key->expire < (time() + 180)) return false;

        return ['url' => $check->qrcode->$key->url, 'expire' => $check->qrcode->$key->expire];
    }

    /**
     * 二维码: 检查有效性
     *
     */
    private function checkKey($key)
    {
        $limit = ['workmate', 'angent', 'customer'];
        if(!in_array($key, $limit)) abort('403');

        $r = new Role;
        if($key == 'angent' && !$r->staff()) abort('403');
        if($key == 'customer' && !$r->angent()) abort('403');
    }

    /**
     * 二维码
     *
     */
    public function ad($key=0)
    {
        // 有效性
        $this->checkKey($key);

        $qrcode = [];

        for ($i=0; $i < 2; $i++) { 
            if(!$this->checkQrcode($key)) { 
                $this->setQrcode($key);
                sleep(2);
            }else{
                $qrcode = $this->checkQrcode($key);
                break;
            }
        }

        return view('ad', compact('qrcode'));
    }


    /**
     * 推荐二维码
     *
     */
    public function new()
    {
        return view('new');
    }

    // 注册
    public function register()
    {

        if(!Session::has('openid') || !Cache::has(session('openid')) || Session::has('id')) abort('401');

        $form = $this->form(RegisterForm::class, [
            'method' => 'POST',
            'url' => '/reg_check'
        ]);

        $title = '注册: 需30分钟内完成 <a class="btn btn-danger btn-sm text-white" href="/cancel_reg">取消注册</a>';
        $icon = 'user-o';

        return view('form', compact('form','title','icon'));
    }

    /**
     * 取消注册
     *
     */
    public function regCancel()
    {
        if(Session::has('openid'))) {
            if(Cache::has(session('openid'))) Cache::forget(session('openid'));
            Session::forget('openid');
        }

        Auth::logout();
        return redirect('/');
    }

    /**
     * 注册检查
     *
     */
    public function regCheck(Request $request) 
    {
        $form = $this->form(RegisterForm::class);

        // 输入校验
        $v = new Validator;
        if(!$v->checkMobile($request->mobile)) return redirect()->back()->withErrors(['mobile'=>'手机号不正确!'])->withInput();
        if($request->password !== $request->confirm_password) redirect()->back()->withErrors(['confirm_password'=>'密码不一致!'])->withInput();

        $exists = User::where('accounts->mobile', $request->mobile)
                        ->first();

        if($exists) return redirect()->back()->withErrors(['mobile'=>'手机号已存在!'])->withInput();

        // 单位
        $array = explode('_', Cache::get(session('openid')));

        $u = User::findOrFail($array[2])->first();

        $org_id = $u->org_id;

        $r = new Role;

        // 是否需要审批
        $need = $r->admin($array[2]) || $r->master($array[2]) ? null : '{"locked":true,"pass":false}';
        $text = $r->admin($array[2]) || $r->master($array[2]) ? '恭喜,您可以使用本系统了!' : '您的注册资料已经提交审核, 请耐心等待!';

        if($request->org_name) {
            $org_exsists = Org::where('name', $request->org_name)->first();
            if($exists) return redirect()->back()->withErrors(['mobile'=>'单位名称已存在!'])->withInput();

            // conf_id
            $do = end($array);

            $conf_id = Conf::where('type', 'org')
                            ->where('key', $do)
                            ->firstOrFail();

            $new_org = [
                'name' => $request->org_name,
                'parent_id' => $u->org_id,
                'conf_id' => $conf_id->id,
                'info' => '{"city": "'.$request->city.'", "province": "'.$request->province.'", "sub_city": "'.$request->sub_city.'", "addr":"'.$request->org_addr.'", "content":"'.$request->org_content.'"}',
                'auth' => $need,
            ];

            $n = Org::create($new_org);
            $org_id = $n->id;

        }
        
        $new = [
            'parent_id' => $array[2],
            'org_id' => $org_id,
            'accounts' => '{"mobile":"'.$request->mobile.'", "openid":"'.session('openid').'"}',
            'password' => bcrypt($request->password),
            'info' => '{"name":"'.$request->name.'", "addr":"'.$request->addr.'"}',
            'auth' => $need,
        ];

        $new = User::create($new);

        Cache::forget(session('openid'));

        Auth::login($new);

        // $text = '您的注册资料已经提交审核, 请耐心等待!';
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



















