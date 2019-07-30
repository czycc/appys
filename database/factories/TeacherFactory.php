<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Teacher::class, function (Faker $faker) {

    $imgs = [
        'https://woheniys.oss-cn-hangzhou.aliyuncs.com/test/xAuDMxteQy.png',
        'https://woheniys.oss-cn-hangzhou.aliyuncs.com/test/s5ehp11z6s.png',
        'https://woheniys.oss-cn-hangzhou.aliyuncs.com/test/ZqM7iaP4CR.png',
        'https://woheniys.oss-cn-hangzhou.aliyuncs.com/test/NDnzMutoxX.png',
        'https://woheniys.oss-cn-hangzhou.aliyuncs.com/test/Lhd1SHqu86.png',
        'https://woheniys.oss-cn-hangzhou.aliyuncs.com/test/LOnMrqbHJn.png',
    ];
    $videos = [
        'https://unitytouch.oss-cn-shanghai.aliyuncs.com/yhm/production/GreenVideo/2018-09-27-18-32-09.mp4',
        'https://unitytouch.oss-cn-shanghai.aliyuncs.com/yhm/production/GreenVideo/2018-09-27-18-37-13.mp4',
        'https://unitytouch.oss-cn-shanghai.aliyuncs.com/yhm/production/GreenVideo/2018-09-27-18-46-44.mp4',
        'https://unitytouch.oss-cn-shanghai.aliyuncs.com/yhm/production/GreenVideo/2018-09-29-08-58-22.mp4',
        'https://unitytouch.oss-cn-shanghai.aliyuncs.com/yhm/production/GreenVideo/2018-09-28-12-22-40.mp4'
    ];

    static $password;
    $now = \Carbon\Carbon::now()->toDateTimeString();
    return [
        'name' => $faker->name,
        'password' => $password ?: $password = bcrypt('secret'), // secret
        'remember_token' => str_random(10),
        'desc' => $faker->sentence,
        'video_url' => $faker->randomElement($videos),
        'imgs' => $imgs,
        'created_at' => $now,
        'updated_at' => $now
    ];
});
