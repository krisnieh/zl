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
            'accounts' =>'{"mobile":"17821621090", "open_id":"wechatopenid"}',
            'password' => bcrypt('000000'),
            'info' => '{"name":"Kris", "sex":"male"}',
            'auth' => '{"root":true}'
        ]);

        User::create([
            'parent_id' => 1,
            'accounts' =>'{"mobile":"17261750890", "open_id":"wechatopenid"}',
            'password' => bcrypt('000000'),
            'info' => '{"name":"吴清国", "sex":"male"}',
            'auth' => '{"admin":true}'
        ]);

        User::create([
            'parent_id' => 2,
            'accounts' =>'{"mobile":"13000000000", "open_id":"wechatopenid"}',
            'password' => bcrypt('000000'),
            'info' => '{"name":"陈东阳", "sex":"male"}',
            'auth' => '{"manager":true}'
        ]);

        User::create([
            'parent_id' => 2,
            'accounts' =>'{"mobile":"131231231", "open_id":"wechatopenid"}',
            'password' => bcrypt('000000'),
            'info' => '{"name":"令狐冲", "sex":"male"}',
            'auth' => null
        ]);

        User::create([
            'parent_id' => 2,
            'accounts' =>'{"mobile":"17821121090", "open_id":"wechatopenid"}',
            'password' => bcrypt('000000'),
            'info' => '{"name":"任盈盈", "sex":"female"}',
            'auth' => '{"locked":true}'
        ]);
    }
}

