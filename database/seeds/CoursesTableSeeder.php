<?php

use Illuminate\Database\Seeder;
use App\Models\Course;

class CoursesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = app(\Faker\Generator::class);
        $banner = [
            'https://unitytouch.oss-cn-shanghai.aliyuncs.com/ZhangChi/MultiAnglePhoto/20180927144942-1.png',
            'https://unitytouch.oss-cn-shanghai.aliyuncs.com/ZhangChi/MultiAnglePhoto/20180928145210-1.png',
            'https://unitytouch.oss-cn-shanghai.aliyuncs.com/ZhangChi/MultiAnglePhoto/20180928094455-1.png',
            'https://unitytouch.oss-cn-shanghai.aliyuncs.com/ZhangChi/MultiAnglePhoto/20180927151002-1.png',
            'https://unitytouch.oss-cn-shanghai.aliyuncs.com/ZhangChi/MultiAnglePhoto/20180927140458-1.png'
        ];
        $cates = \App\Models\CourseCategory::all()->pluck('id')->toArray();
        $teachers = \App\Models\Teacher::all()->pluck('id')->toArray();
        $courses = factory(Course::class)
            ->times(50)
            ->make()
            ->each(function ($course, $index) use ($faker, $banner, $teachers, $cates) {
            $course->banner = $faker->randomElement($banner);
            $course->teacher_id = $faker->randomElement($teachers);
            $course->category_id = $faker->randomElement($cates);
            });

        Course::insert($courses->toArray());
    }

}

