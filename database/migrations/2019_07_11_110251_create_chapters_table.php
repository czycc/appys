<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChaptersTable extends Migration 
{
	public function up()
	{
		Schema::create('chapters', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title')->index();
            $table->integer('price')->unsigned()->default(0);
            $table->string('media_type');
            $table->text('media_url');
            $table->integer('course_id')->unsigned();
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('chapters');
	}
}
