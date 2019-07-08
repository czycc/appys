<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->index();
            $table->text('body');
            $table->text('thumbnail')->nullable()->commit('缩略图');
            $table->enum('media_type', ['video', 'audio'])->default('audio')->commit('媒体类型');
            $table->text('media_url')->nullable()->commit('媒体路径');
            $table->integer('view_count')->default(0)->unsigned();
            $table->integer('zan_count')->index()->default(0);
            $table->integer('order')->default(0)->commit('权重');
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
        Schema::dropIfExists('news');
    }
}
