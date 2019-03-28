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
            'name' => '众乐速配',
            'type' => 3,
            'info' => '{"province":"江苏", "city":"无锡", "sub_city":"无锡"}',
            'auth' => '{"root":true}'
        ]);

        Org::create([
            'name' => '湖兴',
            'type' => 4,
            'info' => '{"province":"江苏", "city":"常州", "sub_city":"溧阳"}',
            'auth' => null
        ]);

        Org::create([
            'name' => '锡城特快',
            'type' => 4,
            'info' => '{"province":"江苏", "city":"无锡", "sub_city":"无锡"}',
            'auth' => null
        ]);

        Org::create([
            'name' => '江阴飞龙',
            'type' => 4,
            'info' => '{"province":"江苏", "city":"无锡", "sub_city":"江阴"}',
            'auth' => null
        ]);

        Org::create([
            'name' => '宜兴中天',
            'type' => 4,
            'info' => '{"province":"江苏", "city":"无锡", "sub_city":"宜兴"}',
            'auth' => null
        ]);

    }
}
