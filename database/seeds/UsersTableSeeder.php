<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(\App\Models\User::class, 100)->create();

        $user = \App\Models\User::find(1);
        $user->nickname = 'czy';
        $user->phone = '13331936826';
        $user->avatar = 'https://woheniys.oss-cn-hangzhou.aliyuncs.com/test/ZqM7iaP4CR.png';
        $user->bound_id = 0;
        $user->bound_status = 0;
        $user->save();
    }
}
