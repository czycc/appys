<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\User::class, function (Faker $faker) {
    static $password;
    $now = \Carbon\Carbon::now()->toDateTimeString();
    $avatars = [
        'https://woheniys.oss-cn-hangzhou.aliyuncs.com/test/xAuDMxteQy.png',
        'https://woheniys.oss-cn-hangzhou.aliyuncs.com/test/s5ehp11z6s.png',
        'https://woheniys.oss-cn-hangzhou.aliyuncs.com/test/ZqM7iaP4CR.png',
        'https://woheniys.oss-cn-hangzhou.aliyuncs.com/test/NDnzMutoxX.png',
        'https://woheniys.oss-cn-hangzhou.aliyuncs.com/test/Lhd1SHqu86.png',
        'https://woheniys.oss-cn-hangzhou.aliyuncs.com/test/LOnMrqbHJn.png',
    ];
    return [
        'nickname' => $faker->name,
        'phone' => $faker->numberBetween(10000000000, 99999999999),
        'password' => $password ?: $password = bcrypt('secret'), // secret
        'remember_token' => str_random(10),
        'code' => uniqid(),
        'wx_openid' => str_random(20),
        'wx_unionid' => str_random(20),
        'vip' => $faker->numberBetween(0, 2),
        'expire_at' => $faker->dateTimeThisMonth(Carbon\Carbon::now()->addDays(20)),
        'created_at' => $now,
        'updated_at' => $now,
        'bound_id' => $faker->numberBetween(0, 5),
        'bound_status' => $faker->boolean,
        'avatar' => $faker->randomElement($avatars),
    ];
});
