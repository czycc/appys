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
            $table->string('code')->nullbale()->commit('推荐码');
            $table->string('nickname')->nullable()->commit('昵称');
            $table->text('avatar')->nullable()->commit('头像');
            $table->string('wx_openid', 100)->nullable()->index()->commit('微信openid');
            $table->string('wx_unionid', 100)->nullable()->index()->commit('微信unionid');
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
