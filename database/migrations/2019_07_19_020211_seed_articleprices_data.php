<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedArticlepricesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $data = [
            [
                'price' => 0.00,
            ],
            [
                'price' => 1.00,
            ],
            [
                'price' => 5.00,
            ],[
                'price' => 10.00,
            ],
        ];
        \Illuminate\Support\Facades\DB::table('article_prices')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('article_prices')->truncate();
    }
}
