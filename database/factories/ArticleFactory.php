<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Article::class, function (Faker $faker) {
    $sentence = $faker->sentence();
    $updated_at = $faker->dateTimeThisMonth();
    $created_at = $faker->dateTimeThisMonth($updated_at);
    return [
        'title' => $sentence,
        'body' => $faker->randomHtml(),
        'top_img' => 'https://h5-touch.oss-cn-shanghai.aliyuncs.com/project/abbott/a011.JPG',
        'zan_count' => $faker->numberBetween(0, 1000),
        'price' => $faker->numberBetween(0, 5),
        'status' => $faker->randomElement([0, 1, 2]),
        'created_at' => $created_at,
        'updated_at' => $updated_at,
    ];
});
