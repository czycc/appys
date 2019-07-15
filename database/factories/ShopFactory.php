<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Shop::class, function (Faker $faker) {
    $imgs = [
        'https://h5-touch.oss-cn-shanghai.aliyuncs.com/project/abbott/a2.JPG',
        'https://h5-touch.oss-cn-shanghai.aliyuncs.com/project/abbott/a41.JPG',
        'https://h5-touch.oss-cn-shanghai.aliyuncs.com/project/abbott/a12.JPG',
        'https://h5-touch.oss-cn-shanghai.aliyuncs.com/project/abbott/a02.JPG',
        'https://h5-touch.oss-cn-shanghai.aliyuncs.com/project/abbott/a1.JPG',
        'https://h5-touch.oss-cn-shanghai.aliyuncs.com/project/abbott/A39.JPG',
        'https://h5-touch.oss-cn-shanghai.aliyuncs.com/project/abbott/a08.JPG'
    ];

    $updated_at = $faker->dateTimeThisMonth();
    $created_at = $faker->dateTimeThisMonth($updated_at);

    return [
        'shop_phone' => $faker->numberBetween(10000000000, 20000000000),
        'real_name' => $faker->name,
        'banner' => $faker->randomElement($imgs),
        'idcard' => $faker->randomElement($imgs),
        'license' => $faker->randomElement($imgs),
        'shop_imgs' => json_encode($faker->randomElements($imgs)),
        'longitude' => '100.1234567',
        'latitude' => '100.1234567',
        'status' => $faker->numberBetween(0, 2),
        'province' => '安徽省',
        'city' => '合肥市',
        'district' => '蜀山区',
        'address' => '西湖国际广场',
        'created_at' => $created_at,
        'updated_at' => $updated_at,
    ];
});
