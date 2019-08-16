<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration 
{
	public function up()
	{
		Schema::create('courses', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title')->index();
            $table->text('banner');
            $table->decimal('ori_price', 9, 2)->unsigned()->default(0);
            $table->decimal('now_price', 9, 2)->unsigned()->default(0);
            $table->text('body');
            $table->integer('view_count')->default(0);
            $table->integer('zan_count')->default(0);
            $table->integer('buy_count')->index()->default(0);
            $table->boolean('show')->default(1);
            $table->boolean('recommend')->default(0);
            $table->integer('order')->default(0);
            $table->integer('buynote_id')->unsigned()->default(1);
            $table->integer('teacher_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('buynote_id')
                ->references('id')
                ->on('buynotes');

            $table->foreign('teacher_id')
                ->references('id')
                ->on('teachers');

            $table->foreign('category_id')
                ->references('id')
                ->on('course_categories');

        });
	}

	public function down()
	{
		Schema::drop('courses');
	}
}
