<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class FinanceForm extends Form
{
    public function buildForm()
    {
        $this->add('pay', 'number', [
            'label' => '充值金额',
            'default_value' => 0,
            'rules' => 'min:100|max:5000'
        ])
        ->add('submit','submit',[
              'label' => "确定充值金额",
              'attr' => ['class' => 'btn btn-success btn-block']
        ]);
    }
}
