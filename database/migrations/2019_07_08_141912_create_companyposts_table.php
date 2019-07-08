<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyPostsTable extends Migration 
{
	public function up()
	{
		Schema::create('company_posts', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title')->index();
            $table->text('body');
            $table->text('thumbnail')->nullable()->commit('缩略图');
            $table->enum('media_type', ['video', 'audio'])->default('audio')->commit('媒体类型');
            $table->text('media_url')->nullable()->commit('媒体路径');
            $table->integer('category_id')->unsigned();
            $table->integer('view_count')->default(0)->unsigned();
            $table->integer('zan_count')->index()->default(0);
            $table->integer('order')->default(0)->commit('权重');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('company_posts');
	}
}
