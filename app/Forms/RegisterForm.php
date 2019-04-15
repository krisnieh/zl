<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Cache;
use Session;

class RegisterForm extends Form
{

    private function pick()
    {
        if(!Session::has('openid') || Cache::has(session('openid'))) {
            Cache::flush();
            return redirect('/');
        }

        $str = Cache::get(session('openid'));
        $arr = explode('_', $str);
        $do = end($arr);
        return $do;
    }

    public function buildForm()
    {
        if($this->pick() == 'angent') {
            $this
            ->add('province', 'text', [
                'label' => '省',
                'default_value' => '江苏',
                'rules' => 'required|min:2|max:8'
            ])
            ->add('city', 'text', [
                'label' => '市',
                'default_value' => '无锡',
                'rules' => 'required|min:2|max:8'
            ])
            ->add('sub_city', 'text', [
                'label' => '区/县',
                'rules' => 'required|min:2|max:8'
            ]);
        }

        if($this->pick() == 'customer' || $this->pick() == 'angent'){
            $this
            ->add('org_name', 'text', [
                'label' => '单位名称',
                'rules' => 'required|min:2|max:20'
            ])
            ->add('org_addr', 'text', [
                'label' => '单位地址',
                'rules' => 'required|min:5|max:32'
            ])
            ->add('org_content', 'textarea', [
                'label' => '备注',
                'rules' => 'min:2|max:200'
            ]);
        }

        $this
        ->add('name', 'text', [
            'label' => '姓名',
            'rules' => 'required|min:2|max:16'
        ])
        ->add('mobile', 'text', [
            'label' => '手机号',
            'rules' => 'required|min:11|max:11'
        ])
        ->add('password', 'password', [
            'label' => '密码',
            'rules' => 'required|min:4|max:32'
        ])
        ->add('confirm_password', 'password', [
            'label' => '确认密码',
            'rules' => 'required|min:4|max:32'
        ])
        ->add('submit','submit',[
              'label' => "提交",
              'attr' => ['class' => 'btn btn-success btn-block']
        ]);
    }
}
