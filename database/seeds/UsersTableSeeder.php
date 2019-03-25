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
            'info' => '{"name":"Kris", "addr":"无锡"}',
            'auth' => '{"root":true, "type":"staff"}'
        ]);

        User::create([
            'parent_id' => 1,
            'accounts' =>'{"mobile":"17261750890", "openid":"wechatopenid"}',
            'password' => bcrypt('000000'),
            'info' => '{"name":"吴清国", "addr":"无锡江阴青阳"}',
            'auth' => '{"admin":true,"type":"staff"}'
        ]);

        User::create([
            'parent_id' => 2,
            'accounts' =>'{"mobile":"13000000000", "openid":"wechatopenid"}',
            'password' => bcrypt('000000'),
            'info' => '{"name":"陈东阳", "addr":"无锡江阴青阳"}',
            'auth' => '{"manager":true,"type":"staff"}'
        ]);

        User::create([
            'parent_id' => 2,
            'accounts' =>'{"mobile":"131231231", "openid":"wechatopenid"}',
            'password' => bcrypt('000000'),
            'info' => '{"name":"令狐冲", "addr":"无锡江阴青阳"}',
            'auth' => '{"type":"agent"}'
        ]);

        User::create([
            'parent_id' => 2,
            'accounts' =>'{"mobile":"131231231", "openid":"wechatopenid"}',
            'password' => bcrypt('000000'),
            'info' => '{"name":"莫大先生", "addr":"无锡江阴青阳"}',
            'auth' => null
        ]);

        User::create([
            'parent_id' => 2,
            'accounts' =>'{"mobile":"17821121090", "openid":"wechatopenid"}',
            'password' => bcrypt('000000'),
            'info' => '{"name":"任盈盈", "addr":"fexxxxxxyyyy"}',
            'auth' => '{"type":"customer"}'
        ]);
    }
}

