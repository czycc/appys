<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoundScansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bound_scans', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->commment('用户id');
            $table->unsignedInteger('bound_id')->comment('上级id');
            $table->boolean('status')->default(0)->commnet('是否审核');
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
        Schema::dropIfExists('bound_scans');
    }
}
