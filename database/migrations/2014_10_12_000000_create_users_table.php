<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone',11)->unique();
            $table->string('password');
            $table->string('code', 50)->nullbale()->unique()->comment('推荐码');
            $table->string('nickname')->nullable()->comment('昵称');
            $table->text('avatar')->nullable()->comment('头像');
            $table->string('wx_openid', 100)->nullable()->index()->comment('app微信openid');
            $table->string('wap_openid', 100)->nullable()->index()->comment('公众号openid');
            $table->string('wx_unionid', 100)->nullable()->index()->comment('微信unionid');
            $table->integer('gold')->unsigned()->default(0)->comment('金币');
            $table->integer('silver')->unsigned()->default(0)->comment('银币');
            $table->integer('copper')->unsigned()->default(0)->comment('铜币');
            $table->integer('notification_count')->unsigned()->default(0);
            $table->integer('bound_id')->unsigned()->default(0)->comment('上级id');
            $table->boolean('bound_status')->default(0)->comment('绑定状态，用于判断是否绑定');
            $table->tinyInteger('vip')->unsigned()->default(0)->comment('0铜牌，1银牌，2代理');
            $table->dateTime('expire_at')->nullable();
            $table->decimal('balance', 9,2)->default(0);
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
