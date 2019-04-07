<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class OrderForm extends Form
{
    public function buildForm()
    {
        $this->add('gold', 'number', [
            'label' => '金瓶: 0℃',
            'default_value' => 0,
            'rules' => 'min:0|max:99'
        ])
        ->add('black', 'number', [
            'label' => '黑瓶: -15℃',
            'default_value' => 0,
            'rules' => 'min:0|max:99'
        ])
        // ->add('content', 'textarea', [
        //         'label' => '说明',
        //         'rules' => 'min:4|max:200'
        //     ]) 
        ->add('submit','submit',[
              'label' => "确定下单",
              'attr' => ['class' => 'btn btn-success btn-block']
        ]);
    }
}
