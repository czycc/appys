<?php

use Faker\Generator as Faker;

$factory->define(App\Models\CompanyPost::class, function (Faker $faker) {
    $sentence = $faker->sentence();
    $updated_at = $faker->dateTimeThisMonth();
    $created_at = $faker->dateTimeThisMonth($updated_at);
    return [
        'title' => $sentence,
        'body' => $faker->randomHtml(),
        'zan_count' => $faker->numberBetween(0,1000),
        'view_count' => $faker->numberBetween(0,1000),
        'created_at' => $created_at,
        'updated_at' => $updated_at,
    ];
});
