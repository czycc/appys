<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedBuynotesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $note = [
            [
                'body' => '<p>这是一段购买须知</p>'
            ]
        ];
        \Illuminate\Support\Facades\DB::table('buynotes')->insert($note);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\DB::truncate();
    }
}
