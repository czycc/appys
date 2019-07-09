<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedCoursecategoriesData extends Migration
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
                'name' => 'A',
                'desc' => '课程分类'
            ],[
                'name' => 'B',
                'desc' => '课程分类'
            ],[
                'name' => 'C',
                'desc' => '课程分类'
            ],[
                'name' => 'D',
                'desc' => '课程分类'
            ],
        ];

        DB::table('course_categories')->insert($category);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('course_category')->truncate();
    }
}
