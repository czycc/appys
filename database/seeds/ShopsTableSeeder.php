<?php

use Illuminate\Database\Seeder;
use App\Models\Shop;

class ShopsTableSeeder extends Seeder
{
    public function run()
    {
        $users = \App\Models\User::all()->toArray();
        $shops = factory(Shop::class)->times(60)->make()
            ->each(function ($shop, $index) use ($users) {
                $shop->user_id = $users[$index]['id'];
                $shop->expire_at = $users[$index]['expire_at'];
            });

        Shop::insert($shops->toArray());

        //为店铺添加标签
        $tags = \App\Models\Tag::all()->toArray();
        Shop::all()->each(function (Shop $shop) use ($tags) {
            $shop->tags()->attach($tags[random_int(0,2)]['id']);
        });
    }

}

