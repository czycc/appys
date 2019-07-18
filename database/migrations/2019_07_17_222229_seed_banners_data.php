<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedBannersData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //尺寸比例1080 * 560
        $data = [
            [
                'img_url' => 'https://h5-touch.oss-cn-shanghai.aliyuncs.com/testimage/WX20190718-151613.png',
                'desc' => '跳转课程',
                'type' => 'courses',
                'type_id' => 1
            ],
            [
                'img_url' => 'https://h5-touch.oss-cn-shanghai.aliyuncs.com/testimage/WX20190718-152415.png',
                'desc' => '跳转公司文章',
                'type' => 'company_posts',
                'type_id' => 1
            ]
        ];

        DB::table('banners')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('banners')->truncate();
    }
}
