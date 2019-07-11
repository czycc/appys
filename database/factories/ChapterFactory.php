<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Chapter::class, function (Faker $faker) {
    $updated_at = $faker->dateTimeThisMonth();
    $created_at = $faker->dateTimeThisMonth($updated_at);

    return [
        'title' => $faker->sentence(20),
        'media_type' => $faker->randomElement(['audio', 'video']),
        'price' => $faker->numberBetween(0,20),
        'created_at' => $created_at,
        'updated_at' => $updated_at,
    ];
});
