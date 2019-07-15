<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Comment::class, function (Faker $faker) {
    $users = \App\Models\User::all()->pluck('id')->toArray();
    $articles = \App\Models\Article::all()->pluck('id')->toArray();
    $updated_at = $faker->dateTimeThisMonth();
    $created_at = $faker->dateTimeThisMonth($updated_at);
    return [
        'user_id' => $faker->randomElement($users),
        'article_id' => $faker->randomElement($articles),
        'content' =>$faker->sentence,
        'created_at' => $created_at,
        'updated_at' => $updated_at,
    ];
});
