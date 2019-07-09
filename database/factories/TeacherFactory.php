<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Teacher::class, function (Faker $faker) {
    static $password;
    $now = \Carbon\Carbon::now()->toDateTimeString();
    return [
        'name' => $faker->name,
        'password' => $password ?: $password = bcrypt('secret'), // secret
        'remember_token' => str_random(10),
        'desc' => $faker->sentence,
        'created_at' => $now,
        'updated_at' => $now
    ];
});
