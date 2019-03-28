<?php

use Illuminate\Database\Seeder;

use App\Conf;

class ConfsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Conf::create([
            'key' => 'gender',
            'val' => '男',
        ]);
        Conf::create([
            'key' => 'gender',
            'val' => '女',
        ]);

        Conf::create([
            'key' => 'org_type',
            'val' => '众乐速配',
        ]);
        Conf::create([
            'key' => 'org_type',
            'val' => '代理商',
        ]);
        Conf::create([
            'key' => 'org_type',
            'val' => '客户',
        ]);

    }
}
