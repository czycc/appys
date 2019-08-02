<?php

use Faker\Generator as Faker;

$factory->define(App\Models\CompanyPost::class, function (Faker $faker) {
    $sentence = $faker->sentence();
    $updated_at = $faker->dateTimeThisMonth();
    $created_at = $faker->dateTimeThisMonth($updated_at);
    return [
        'title' => $sentence,
        'body' => '<p><br></p><p><b>​</b>事实上<i>这是一段图文内容测试，这是一段图文内容测试，这是一段图文内容测试，</i></p><p><br></p>',
        'zan_count' => $faker->numberBetween(0,1000),
        'view_count' => $faker->numberBetween(0,1000),
        'created_at' => $created_at,
        'updated_at' => $updated_at,
    ];
});
