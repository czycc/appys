<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlowOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flow_outs', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('total_amount', 9, 2)->comment('资金');
            $table->boolean('status')->default(0)->comment('审核状态');
            $table->boolean('out_status')->default(0)->comment('提现状态');
            $table->string('out_method')->comment('提现方式');
            $table->string('ali_account')->nullable();
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('flow_outs');
    }
}
