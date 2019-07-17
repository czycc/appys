<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedTagsData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tags = [
            [
                'name' => '标签1',
                'desc' => '描述1',
                'post_count' => 88
            ],[
                'name' => '标签2',
                'desc' => '描述2',
                'post_count' => 36
            ],[
                'name' => '标签3',
                'desc' => '描述3',
                'post_count' => 102
            ],
        ];
        DB::table('tags')->insert($tags);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('tags')->truncate();
    }
}
