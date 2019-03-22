<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

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
              'label' => '提交',
              'attr' => ['class' => 'btn btn-success btn-block']
        ]);
    }
}
