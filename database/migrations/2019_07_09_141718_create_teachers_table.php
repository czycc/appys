<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeachersTable extends Migration 
{
	public function up()
	{
		Schema::create('teachers', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name',60)->unique();
            $table->string('password');
            $table->text('desc')->nullable();
            $table->text('video_url')->nullable();
            $table->json('imgs');
            $table->rememberToken();
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('teachers');
	}
}
