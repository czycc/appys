<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Article::class, function (Faker $faker) {
    $sentence = $faker->sentence();
    $updated_at = $faker->dateTimeThisMonth();
    $created_at = $faker->dateTimeThisMonth($updated_at);
    return [
        'title' => $sentence,
        'body' => '<p></p><p><br></p><p><b></b>事实上<i>搜索为</i></p><p><img src="https://h5-touch.oss-cn-shanghai.aliyuncs.com/unity-img/5b76a59bd9312.png" style="max-width:100%;"><br></p><h3>这是一段富文本</h3>',
        'top_img' => 'https://h5-touch.oss-cn-shanghai.aliyuncs.com/project/abbott/a011.JPG',
        'zan_count' => $faker->numberBetween(0, 1000),
        'price' => $faker->numberBetween(0, 5),
        'status' => $faker->randomElement([0, 1, 2]),
        'created_at' => $created_at,
        'updated_at' => $updated_at,
    ];
});
