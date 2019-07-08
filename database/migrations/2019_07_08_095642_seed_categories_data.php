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
                'desc' => '公司动态+公司展示',
                'parent_id' => 0,
            ],
            [
                'name' => '用户发布',
                'desc' => '用户文章视频音频',
                'parent_id' => 0,
            ],
            [
                'name' => '课程',
                'desc' => '课程类型',
                'parent_id' => 0,
            ],
            [
                'name' => '平台素材库',
                'desc' => '由平台进行素材发布',
                'parent_id' => 0,
            ],
            [
                'name' => '公司动态',
                'desc' => '公司简介分类下的子分类',
                'parent_id' => 1
            ],
            [
                'name' => '公司展示',
                'desc' => '公司简介分类下的子分类',
                'parent_id' => 1,
            ]

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
