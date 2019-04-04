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
            'key' => 'root',
            'order' => 1,
            'val' => 'root',
        ]);
        Conf::create([
            'type' => 'org',
            'key' => 'invalid',
            'order' => 2,
            'val' => '待审核',
        ]);
        Conf::create([
            'type' => 'org',
            'key' => 'staff',
            'order' => 3,
            'val' => '内部',
        ]);
        Conf::create([
            'type' => 'org',
            'key' => 'angent',
            'order' => 4,
            'val' => '代理商',
        ]);
        Conf::create([
            'type' => 'org',
            'order' => 5,
            'key' => 'customer',
            'val' => '客户',
        ]);

    }
}
