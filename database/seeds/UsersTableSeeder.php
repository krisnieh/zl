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
            'org_id' => 3,
            'accounts' =>'{"mobile":"17821621090", "openid":"ojK9v1ZaCM4AnDe_iMjf5AQM61II"}',
            'password' => bcrypt('000000'),
            'info' => '{"name":"Kris", "addr":"无锡"}',
            'auth' => '{"root":true}'
        ]);

        User::create([
            'parent_id' => 1,
            'org_id' => 3,
            'accounts' =>'{"mobile":"17261750890", "openid":"wechatopenid"}',
            'password' => bcrypt('000000'),
            'info' => '{"name":"吴清国", "addr":"无锡江阴青阳"}',
            'auth' => '{"root":true}'
        ]);

        User::create([
            'parent_id' => 2,
            'org_id' => 3,
            'accounts' =>'{"mobile":"13000000000", "openid":"wechatopenid"}',
            'password' => bcrypt('000000'),
            'info' => '{"name":"陈东阳", "addr":"无锡江阴青阳"}',
            'auth' => '{"admin":true}'
        ]);

        User::create([
            'parent_id' => 2,
            'org_id' => 3,
            'accounts' =>'{"mobile":"13111111111", "openid":"wechatopenid"}',
            'password' => bcrypt('000000'),
            'info' => '{"name":"周芷若", "addr":"无锡江阴青阳"}',
            'auth' => '{"master":true}'
        ]);

        User::create([
            'parent_id' => 2,
            'org_id' => 3,
            'accounts' =>'{"mobile":"13222222222", "openid":"wechatopenid"}',
            'password' => bcrypt('000000'),
            'info' => '{"name":"丁敏君", "addr":"无锡江阴青阳"}',
            'auth' => null
        ]);

        User::create([
            'parent_id' => 2,
            'org_id' => 7,
            'accounts' =>'{"mobile":"13444444444", "openid":"wechatopenid"}',
            'password' => bcrypt('000000'),
            'info' => '{"name":"令狐冲", "addr":"无锡江阴青阳"}',
            'auth' => '{"master":true}'
        ]);

        User::create([
            'parent_id' => 2,
            'org_id' => 7,
            'accounts' =>'{"mobile":"13555555555", "openid":"wechatopenid"}',
            'password' => bcrypt('000000'),
            'info' => '{"name":"任盈盈", "addr":"fexxxxxxyyyy"}',
            'auth' => null
        ]);

        User::create([
            'parent_id' => 2,
            'org_id' => 9,
            'accounts' =>'{"mobile":"13666666666", "openid":"wechatopenid"}',
            'password' => bcrypt('000000'),
            'info' => '{"name":"莫大先生", "addr":"无锡江阴新桥"}',
            'auth' => '{"master":true}'
        ]);

        
    }
}

