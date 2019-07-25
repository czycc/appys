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
            $table->integer('distribute1_vip')->unsigned()->commit('vip一级分销比例,百分比');
            $table->integer('distribute2_vip')->unsigned()->commit('vip二级级分销比例,百分比');
            $table->integer('distribute3_vip')->unsigned()->commit('vip三级分销比例,百分比');
            $table->integer('distribute1_course')->unsigned()->commit('course一级分销比例,百分比');
            $table->integer('distribute2_course')->unsigned()->commit('course二级级分销比例,百分比');
            $table->integer('distribute3_course')->unsigned()->commit('course三级分销比例,百分比');
            $table->integer('pub_self')->unsigned()->commit('文章购买个人分销比例,百分比');
            $table->integer('pub_plat')->unsigned()->commit('文章购买平台分销比例,百分比');
            $table->decimal('vip2_price_n', 9, 2)->unsigned()->commit('银牌会员无上级购买价格');
            $table->decimal('vip2_price_y', 9, 2)->unsigned()->commit('银牌会员有上级购买价格');
            $table->decimal('vip3_price', 9, 2)->unsigned()->commit('代理价格,线下缴费');
            $table->integer('invite_copper')->unsigned()->commit('邀请用户得铜币数');
            $table->integer('zan_copper')->unsigned()->commit('点赞得铜币数');
            $table->integer('copper_pay_percent')->unsigned()->commit('铜币兑换比例');
            $table->integer('copper_pay_num')->unsigned()->commit('1元兑铜币数量');
            $table->integer('buy_vip2_self')->unsigned()->commit('购买银牌会员自己得银币数');
            $table->integer('buy_vip2_top_vip2')->unsigned()->commit('购买银牌会员上级是银牌会员得银币数');
            $table->integer('buy_vip2_top_vip3')->unsigned()->commit('购买银牌会员上级是代理得金币数');
            $table->integer('buy_vip3_top_vip2')->unsigned()->commit('购买代理上级是银牌得银币数');
            $table->integer('buy_vip3_top_vip3')->unsigned()->commit('购买代理上级是代理得金币数');

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
