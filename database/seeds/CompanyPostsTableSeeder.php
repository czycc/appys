<?php

use Illuminate\Database\Seeder;
use App\Models\CompanyPost;

class CompanyPostsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = app(\Faker\Generator::class);
        $thumbnail = [
            'https://woheniys.oss-cn-hangzhou.aliyuncs.com/test/xAuDMxteQy.png',
            'https://woheniys.oss-cn-hangzhou.aliyuncs.com/test/s5ehp11z6s.png',
            'https://woheniys.oss-cn-hangzhou.aliyuncs.com/test/ZqM7iaP4CR.png',
            'https://woheniys.oss-cn-hangzhou.aliyuncs.com/test/NDnzMutoxX.png',
            'https://woheniys.oss-cn-hangzhou.aliyuncs.com/test/Lhd1SHqu86.png',
            'https://woheniys.oss-cn-hangzhou.aliyuncs.com/test/LOnMrqbHJn.png',
        ];
        $cateids = \App\Models\CompanyCategory::where('is_directory', 0)->get()
            ->pluck('id')
            ->toArray();
        $company_posts = factory(CompanyPost::class)
            ->times(100)
            ->make()
            ->each(function ($company_post, $index) use ($faker, $thumbnail, $cateids) {
                $company_post->thumbnail = $faker->randomElement($thumbnail);
                $company_post->category_id = $faker->randomElement($cateids);
                if ($index % 2 == 0) {
                    $company_post->media_type = 'video';
                    $company_post->media_url = 'https://unitytouch.oss-cn-shanghai.aliyuncs.com/yhm/production/1.mp4';
                } else {
                    $company_post->media_type = 'audio';
                    $company_post->media_url = 'https://unitytouch.oss-cn-shanghai.aliyuncs.com/Zzc/Projects/ZhaDaBank/0102121131.mp3';

                }
            });

        CompanyPost::insert($company_posts->toArray());

        //添加标签
        $tags = \App\Models\Tag::all()->pluck('id');

        $company_posts = CompanyPost::all();
        foreach ($company_posts as $item) {
            $item->tags()->attach($faker->randomElements($tags));
        }
    }

}

