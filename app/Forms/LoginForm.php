<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
// use App\Helpers\Prepare;

class LoginForm extends Form
{
    public function buildForm()
    {
        $this->add('mobile', 'text', [
            'label' => '手机号',
            'rules' => 'required|min:11|max:11'
        ])
        ->add('password', 'password', [
            'label' => '密码',
            'rules' => 'required|min:4|max:32'
        ])
        ->add('submit','submit',[
              'label' => strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') ? "登录并关联此微信" : "登录",
              'attr' => ['class' => 'btn btn-success btn-block']
        ]);
    }
}
