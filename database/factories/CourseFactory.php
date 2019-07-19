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
        'body' => $faker->text,
        'view_count' => $faker->numberBetween(0,1000),
        'buy_count' => $faker->numberBetween(0,1000),
        'zan_count' => $faker->numberBetween(0,1000),
        'recommend' => $faker->boolean(),
        'created_at' => $created_at,
        'updated_at' => $updated_at,
    ];
});
