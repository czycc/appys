<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration 
{
	public function up()
	{
		Schema::create('comments', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('article_id')->unsigned()->default(0)->index();
            $table->integer('user_id')->unsigned()->default(0)->index();
            $table->integer('comment_id')->unsigned()->nullable();
            $table->text('content');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('comments');
	}
}
