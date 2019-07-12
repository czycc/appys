<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedConfiguresData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $data = [
            'distributor1' => 10,
            'distributor2' => 1,
            'distributor3' => 1,
            'vip2_price_n' => 2,
            'vip2_price_y' => 1,
            'vip3_price' => 1000,
            'invite_copper' => 10,
            'zan_copper' => 1,
            'buy_vip2_self' => 10,
            'buy_vip2_top_vip2' => 10,
            'buy_vip2_top_vip3' => 10,
            'buy_vip3_top_vip2' => 10,
            'buy_vip3_top_vip3' => 10,

        ];
        DB::table('configures')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('configures')->truncate();
    }
}
