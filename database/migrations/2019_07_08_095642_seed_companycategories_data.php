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
                'name' => '公司动态',
                'desc' => '公司简介分类下的子分类',
            ],
            [
                'name' => '公司展示',
                'desc' => '公司简介分类下的子分类',
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
