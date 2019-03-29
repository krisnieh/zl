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
            'type' => 'gender',
            'key' => 'male',
            'val' => '男',
        ]);
        Conf::create([
            'type' => 'gender',
            'key' => 'female',
            'val' => '女',
        ]);

        Conf::create([
            'type' => 'org',
            'key' => 'invalid',
            'val' => '未分配',
        ]);
        Conf::create([
            'type' => 'org',
            'key' => 'staff',
            'val' => '众乐速配',
        ]);
        Conf::create([
            'type' => 'org',
            'key' => 'angent',
            'val' => '代理商',
        ]);
        Conf::create([
            'type' => 'org',
            'key' => 'customer',
            'val' => '客户',
        ]);

    }
}
