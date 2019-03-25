<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class RegisterForm extends Form
{
    public function buildForm()
    {
        $this
        ->add('name', 'text', [
            'label' => '姓名',
            'rules' => 'required|min:2|max:16'
        ])
        ->add('mobile', 'text', [
            'label' => '手机号',
            'rules' => 'required|min:11|max:11'
        ])
        ->add('addr', 'text', [
            'label' => '地址',
            'rules' => 'required|min:3|max:32'
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
