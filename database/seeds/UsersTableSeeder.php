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
            'info' => '{"name":"Kris", "sex":"male"}',
            'auth' => '{"root":true}'
        ]);

        User::create([
            'parent_id' => 1,
            'accounts' =>'{"mobile":"17261750890", "openid":"wechatopenid"}',
            'password' => bcrypt('000000'),
            'info' => '{"name":"吴清国", "sex":"male"}',
            'auth' => '{"admin":true}'
        ]);

        User::create([
            'parent_id' => 2,
            'accounts' =>'{"mobile":"13000000000", "openid":"wechatopenid"}',
            'password' => bcrypt('000000'),
            'info' => '{"name":"陈东阳", "sex":"male"}',
            'auth' => '{"manager":true}'
        ]);

        User::create([
            'parent_id' => 2,
            'accounts' =>'{"mobile":"131231231", "openid":"wechatopenid"}',
            'password' => bcrypt('000000'),
            'info' => '{"name":"令狐冲", "sex":"male"}',
            'auth' => null
        ]);

        User::create([
            'parent_id' => 2,
            'accounts' =>'{"mobile":"17821121090", "openid":"wechatopenid"}',
            'password' => bcrypt('000000'),
            'info' => '{"name":"任盈盈", "sex":"female"}',
            'auth' => '{"locked":true}'
        ]);
    }
}

