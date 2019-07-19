<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration 
{
	public function up()
	{
		Schema::create('shops', function(Blueprint $table) {
            $table->increments('id');
            $table->string('shop_phone');
            $table->string('real_name');
            $table->string('banner');
            $table->string('idcard');
            $table->string('license');
            $table->json('shop_imgs');
            $table->decimal('longitude', 10, 7);
            $table->decimal('latitude', 10, 7);
            $table->tinyinteger('status')->default(2)->comment('审核状态');
            $table->dateTime('expire_at')->nullable();
            $table->tinyInteger('recommend')->default(0);
            $table->string('province');
            $table->string('city');
            $table->string('district');
            $table->string('address');
            $table->string('wechat_qrcode')->nullable();
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
	}

	public function down()
	{
		Schema::drop('shops');
	}
}
