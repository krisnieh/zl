<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use App\Helpers\Prepare;

class LoginForm extends Form
{
    $p = new Prepare;
    $title = $p->useWechat() ? "登录并关联此微信" : "登录"

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
              'label' => $title,
              'attr' => ['class' => 'btn btn-success btn-block']
        ]);
    }
}
