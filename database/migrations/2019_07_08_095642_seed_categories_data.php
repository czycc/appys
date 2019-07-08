<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedCategoriesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $category = [
            [
                'name' => '公司简介',
                'desc' => '公司动态+公司展示'
            ],
            [
                'name' => '用户发布',
                'desc' => '用户文章视频音频'
            ],
            [
                'name' => '课程',
                'desc' => '课程类型'
            ],
            [
                'name' => '平台素材库',
                'desc' => '由平台进行素材发布'
            ],

        ];
        \Illuminate\Support\Facades\DB::table('categories')->insert($category);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\DB::table('categories')->truncate();
    }
}
