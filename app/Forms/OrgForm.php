<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class OrgForm extends Form
{
    public function buildForm()
    {
        $this->add('name', 'text', [
            'label' => '名称',
            'rules' => 'required|min:11|max:11'
        ])
        ->add('addr', 'text', [
            'label' => '地址',
            'rules' => 'required|min:4|max:32'
        ])
        ->add('content', 'textarea', [
                'label' => '说明',
                'rules' => 'min:4|max:200'
            ]) 
        ->add('submit','submit',[
              'label' => strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') ? "登录并关联此微信" : "登录",
              'attr' => ['class' => 'btn btn-success btn-block']
        ]);
    }
}
