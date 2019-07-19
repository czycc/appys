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
            $table->string('code', 50)->nullbale()->unique()->commit('推荐码');
            $table->string('nickname')->nullable()->commit('昵称');
            $table->text('avatar')->nullable()->commit('头像');
            $table->string('wx_openid', 100)->nullable()->index()->commit('微信openid');
            $table->string('wx_unionid', 100)->nullable()->index()->commit('微信unionid');
            $table->integer('gold')->unsigned()->default(0)->commit('金币');
            $table->integer('silver')->unsigned()->default(0)->commit('银币');
            $table->integer('copper')->unsigned()->default(0)->commit('铜币');
            $table->integer('notification_count')->unsigned()->default(0);
            $table->integer('bound_id')->unsigned()->default(0);
            $table->boolean('bound_status')->default(0);
            $table->tinyInteger('vip')->unsigned()->default(0);
            $table->dateTime('expire_at')->nullable();
            $table->unsignedInteger('zan_count')->default(0);
            $table->rememberToken();
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
