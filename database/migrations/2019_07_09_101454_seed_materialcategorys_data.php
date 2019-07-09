<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedMaterialcategorysData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $desc = '平台素材库类别类别';
        $category = [
            [
                'name' => '微营销',
                'desc' => $desc,
            ],
            [
                'name' => '男性健康',
                'desc' => $desc,
            ],[
                'name' => '女性健康',
                'desc' => $desc,
            ],[
                'name' => '国学',
                'desc' => $desc,
            ],[
                'name' => '心理健康',
                'desc' => $desc,
            ],

        ];
        \Illuminate\Support\Facades\DB::table('material_categories')->insert($category);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\DB::table('material_categories')->truncate();
    }
}
