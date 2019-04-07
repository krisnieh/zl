<?php

use Illuminate\Database\Seeder;

use App\Org;

class OrgsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Org::create([
            'name' => 'root',
            'conf_id' => 3,
            'parent_id' => 1,
            'info' => null,
            'auth' => null
        ]);
        Org::create([
            'name' => '待审批',
            'conf_id' => 4,
            'parent_id' => 1,
            'info' => '{"province":"江苏", "city":"无锡", "sub_city":"无锡"}',
            'auth' => '{"locked":true}'
        ]);

        Org::create([
            'name' => '众乐速配',
            'conf_id' => 5,
            'parent_id' => 1,
            'info' => '{"province":"江苏", "city":"无锡", "sub_city":"无锡"}',
            'auth' => '{"root":true}'
        ]);

        Org::create([
            'name' => '常州速配',
            'conf_id' => 5,
            'parent_id' => 3,
            'info' => '{"province":"江苏", "city":"无锡", "sub_city":"常州"}',
            'auth' => '{"root":true}'
        ]);

        Org::create([
            'name' => '湖兴',
            'conf_id' => 6,
            'parent_id' => 3,
            'info' => '{"province":"江苏", "city":"常州", "sub_city":"溧阳"}',
            'auth' => null
        ]);

        Org::create([
            'name' => '锡城特快',
            'conf_id' => 6,
            'parent_id' => 3,
            'info' => '{"province":"江苏", "city":"无锡", "sub_city":"无锡"}',
            'auth' => null
        ]);

        Org::create([
            'name' => '江阴飞龙',
            'conf_id' => 6,
            'parent_id' => 3,
            'info' => '{"province":"江苏", "city":"无锡", "sub_city":"江阴"}',
            'auth' => null
        ]);

        Org::create([
            'name' => '宜兴中天',
            'conf_id' => 6,
            'parent_id' => 3,
            'info' => '{"province":"江苏", "city":"无锡", "sub_city":"宜兴"}',
            'auth' => null
        ]);

        Org::create([
            'name' => '新桥修理店',
            'conf_id' => 7,
            'parent_id' => 7,
            'info' => '{"addr":"江阴新桥镇胡叶街128号"}',
            'auth' => null
        ]);

    }
}
