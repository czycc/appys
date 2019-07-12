<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfiguresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configures', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('distributor1')->unsigned()->default(10)->commit('一级分销比例,百分比');
            $table->integer('distributor2')->unsigned()->default(1)->commit('二级级分销比例,百分比');
            $table->integer('distributor3')->unsigned()->default(1)->commit('三级分销比例,百分比');
            $table->decimal('vip2_price_n', 5, 2)->unsigned()->default(2)->commit('银牌会员无上级购买价格');
            $table->decimal('vip2_price_y', 5, 2)->unsigned()->default(1)->commit('银牌会员有上级购买价格');
            $table->integer('vip3_price')->unsigned()->default(1000)->commit('代理价格,线下缴费');
            $table->integer('invite_copper')->unsigned()->default(10)->commit('邀请用户得铜币数');
            $table->integer('zan_copper')->unsigned()->default(10)->commit('点赞得铜币数');
            $table->integer('buy_vip2_self')->unsigned()->default(10)->commit('购买银牌会员自己得银币数');
            $table->integer('buy_vip2_top_vip2')->unsigned()->default(10)->commit('购买银牌会员上级是银牌会员得银币数');
            $table->integer('buy_vip2_top_vip3')->unsigned()->default(10)->commit('购买银牌会员上级是代理得金币数');
            $table->integer('buy_vip3_top_vip2')->unsigned()->default(10)->commit('购买代理上级是银牌得银币数');
            $table->integer('buy_vip3_top_vip3')->unsigned()->default(10)->commit('购买代理上级是代理得金币数');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configures');
    }
}
