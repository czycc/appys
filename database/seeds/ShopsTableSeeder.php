<?php

use Illuminate\Database\Seeder;
use App\Models\Shop;

class ShopsTableSeeder extends Seeder
{
    public function run()
    {
        \App\Models\User::all()->each(function (\App\Models\User $user) {
            factory(Shop::class, 1)->create([
                'user_id' => $user->id,
                'expire_at' => $user->expire_at
            ]);
        });

        //为店铺添加标签
        $tags = \App\Models\Tag::all()->toArray();
        Shop::all()->each(function (Shop $shop) use ($tags) {
            $shop->tags()->attach($tags[random_int(0,2)]['id']);
        });
    }

}

