<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Order::class, function (Faker $faker) {
//    $user = \App\Models\User::query()->inRandomOrder()->first();

    return [
        'title' => $faker->sentence,
        'user_id' => random_int(1, 10),
        'total_amount' => random_int(1, 100),
        'paid_at' => $faker->dateTimeBetween(),
        'pay_method' => $faker->randomElement(['wechat', 'alipay']),
        'pay_no' => $faker->uuid,
        'type' => $faker->randomElement([
            'video', 'topic', 'audio', 'course', 'chapter', 'vip'
        ]),
        'type_id' => $faker->numberBetween(1, 30)
    ];
});
