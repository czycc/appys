<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedCompanyCategoriesData extends Migration
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
                'desc' => '主分类',
                'parent_id' => 0,
                'level' => 0,
                'is_directory' => 1
            ],
            [
                'name' => '最新资讯',
                'desc' => '主分类',
                'parent_id' => 0,
                'level' => 0,
                'is_directory' => 0
            ],
            [
                'name' => '平台素材库',
                'desc' => '主分类',
                'parent_id' => 0,
                'level' => 0,
                'is_directory' => 1
            ],

            [
                'name' => '公司动态',
                'desc' => '公司简介分类下的子分类',
                'parent_id' => 1,
                'level' => 1,
                'is_directory' => 0
            ],
            [
                'name' => '公司展示',
                'desc' => '公司简介分类下的子分类',
                'parent_id' => 1,
                'level' => 1,
                'is_directory' => 0
            ],

            [
                'name' => '微营销',
                'desc' => '平台素材库分类下的子分类',
                'parent_id' => 3,
                'level' => 1,
                'is_directory' => 0
            ],
            [
                'name' => '男性健康',
                'desc' => '平台素材库分类下的子分类',
                'parent_id' => 3,
                'level' => 1,
                'is_directory' => 0
            ], [
                'name' => '女性健康',
                'desc' => '平台素材库分类下的子分类',
                'parent_id' => 3,
                'level' => 1,
                'is_directory' => 0
            ], [
                'name' => '国学',
                'desc' => '平台素材库分类下的子分类',
                'parent_id' => 3,
                'level' => 1,
                'is_directory' => 0
            ], [
                'name' => '心理健康',
                'desc' => '平台素材库分类下的子分类',
                'parent_id' => 3,
                'level' => 1,
                'is_directory' => 0
            ]

        ];
        \Illuminate\Support\Facades\DB::table('company_categories')->insert($category);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\DB::table('company_categories')->truncate();
    }
}
