<?php

use Illuminate\Database\Seeder;
use App\Models\Chapter;

class ChaptersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = app(\Faker\Generator::class);
        $cates = \App\Models\Course::all()->pluck('id')->toArray();
        $i = 1;
        $chapters = factory(Chapter::class)
            ->times(120)
            ->make()
            ->each(function ($chapter, $index) use($cates, $i, $faker) {
            if ($chapter->media_type == 'audio') {
                $chapter->media_url = 'https://unitytouch.oss-cn-shanghai.aliyuncs.com/Zzc/Projects/ZhaDaBank/0102121131.mp3';
            } else {
                $chapter->media_url = 'https://unitytouch.oss-cn-shanghai.aliyuncs.com/yhm/production/1.mp4';
            }
            $chapter->course_id = $faker->randomElement($cates);

        });

        Chapter::insert($chapters->toArray());
    }

}

