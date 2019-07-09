<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialsTable extends Migration 
{
	public function up()
	{
		Schema::create('materials', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title')->index();
            $table->text('body');
            $table->text('thumbnail')->nullable();
            $table->string('media_type');
            $table->text('media_url')->nullable();
            $table->integer('view_count')->default(0)->unsigned();
            $table->integer('zan_count')->index()->default(0);
            $table->integer('order')->default(0);
            $table->integer('category_id')->unsigned();
            $table->timestamps();

            $table->foreign('category_id')
                ->references('id')
                ->on('material_categories')
                ->onDelete('cascade');
        });
	}

	public function down()
	{
		Schema::drop('materials');
	}
}
