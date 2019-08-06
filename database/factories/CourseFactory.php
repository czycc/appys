<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Course::class, function (Faker $faker) {
    $price = random_int(0, 15);
    $updated_at = $faker->dateTimeThisMonth();
    $created_at = $faker->dateTimeThisMonth($updated_at);
    return [
        'title' => $faker->sentence,
        'ori_price' => $price,
        'now_price' => random_int(0, $price),
        'body' => '<p></p><p><br></p><p><b></b>事实上<i>搜索为</i></p><p><img src="https://h5-touch.oss-cn-shanghai.aliyuncs.com/unity-img/5b76a59bd9312.png" style="max-width:100%;"><br></p><h3>这是一段富文本</h3>',
        'view_count' => $faker->numberBetween(0,1000),
        'buy_count' => $faker->numberBetween(0,1000),
        'zan_count' => $faker->numberBetween(0,1000),
        'recommend' => $faker->boolean(),
        'created_at' => $created_at,
        'updated_at' => $updated_at,
    ];
});
