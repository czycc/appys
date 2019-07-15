<?php

use Illuminate\Database\Seeder;
use App\Models\Shop;

class ShopsTableSeeder extends Seeder
{
    public function run()
    {
        $users = \App\Models\User::all()->pluck('id')->toArray();
        $shops = factory(Shop::class)->times(10)->make()
            ->each(function ($shop, $index) use($users) {
                 $shop->user_id = $users[$index];
        });

        Shop::insert($shops->toArray());
    }

}

