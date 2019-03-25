<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'parent_id' => 1,
            'accounts' =>'{"mobile":"17821621090", "openid":"ojK9v1ZaCM4AnDe_iMjf5AQM61II"}',
            'password' => bcrypt('000000'),
            'info' => '{"name":"Kris", "addr":"male"}',
            'auth' => '{"root":true, "type":"staff"}'
        ]);

        User::create([
            'parent_id' => 1,
            'accounts' =>'{"mobile":"17261750890", "openid":"wechatopenid"}',
            'password' => bcrypt('000000'),
            'info' => '{"name":"吴清国", "addr":"male"}',
            'auth' => '{"admin":true,"type":"staff"}'
        ]);

        User::create([
            'parent_id' => 2,
            'accounts' =>'{"mobile":"13000000000", "openid":"wechatopenid"}',
            'password' => bcrypt('000000'),
            'info' => '{"name":"陈东阳", "addr":"male"}',
            'auth' => '{"manager":true,"type":"staff"}'
        ]);

        User::create([
            'parent_id' => 2,
            'accounts' =>'{"mobile":"131231231", "openid":"wechatopenid"}',
            'password' => bcrypt('000000'),
            'info' => '{"name":"令狐冲", "addr":"male"}',
            'auth' => '{"type":"agent"}'
        ]);

        User::create([
            'parent_id' => 2,
            'accounts' =>'{"mobile":"131231231", "openid":"wechatopenid"}',
            'password' => bcrypt('000000'),
            'info' => '{"name":"莫大先生", "addr":"male"}',
            'auth' => '{"type":"salesman"}'
        ]);

        User::create([
            'parent_id' => 2,
            'accounts' =>'{"mobile":"17821121090", "openid":"wechatopenid"}',
            'password' => bcrypt('000000'),
            'info' => '{"name":"任盈盈", "addr":"female"}',
            'auth' => '{"type":"customer"}'
        ]);
    }
}

