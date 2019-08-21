<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->unsignedInteger('user_id');
            $table->string('no', 100)->unique();
            $table->decimal('total_amount', 9, 2);
            $table->decimal('deduction', 9, 2)->default('0.00');
            $table->dateTime('paid_at')->nullable();
            $table->string('pay_method')->nullable();
            $table->string('pay_no')->nullable();
            $table->boolean('closed')->default(false);
            $table->unsignedInteger('coin')->default(0);
            $table->enum('type', [
                'video', 'topic', 'audio', 'course', 'chapter', 'vip'
            ])->index()->comment('购买类型');
            $table->unsignedInteger('type_id')->comment('类型对应的id');
            $table->string('extra')->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('orders');
    }
}
