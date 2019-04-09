<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class PasswordForm extends Form
{
    public function buildForm()
    {
        $this->add('password', 'password', [
            'label' => '密码',
            'rules' => 'required|min:4|max:32'
        ])
        ->add('confirm_password', 'password', [
            'label' => '确认密码',
            'rules' => 'required|min:4|max:32'
        ])
        ->add('submit','submit',[
              'label' => "修改",
              'attr' => ['class' => 'btn btn-success btn-block']
        ]);
    }
}
