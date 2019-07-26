<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration 
{
	public function up()
	{
		Schema::create('articles', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title')->index();
            $table->text('top_img');
            $table->text('body');
            $table->enum('media_type', ['video', 'topic', 'audio']);
            $table->text('media_url')->nullable();
            $table->json('multi_imgs')->nullable();
            $table->decimal('price', 9, 2)->default(0);
            $table->integer('zan_count')->index()->default(0);
            $table->integer('user_id')->unsigned();
            $table->tinyInteger('status')->default(2);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
	}

	public function down()
	{
		Schema::drop('articles');
	}
}
