<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuestBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guest_books', function (Blueprint $table) {
            $table->increments('id');
            $table->text('body')->comment('用户留言');
            $table->unsignedInteger('user_id')->comment('留言店铺用户id');
            $table->unsignedInteger('guest_id')->comment('留言用户id');
            $table->unsignedInteger('guest_book_id')->default(0)->comment('回复留言id');
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
        Schema::dropIfExists('guest_books');
    }
}
