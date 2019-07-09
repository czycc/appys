<?php

use Illuminate\Database\Seeder;
use App\Models\CompanyPost;

class CompanyPostsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = app(\Faker\Generator::class);
        $thumbnail = [
            'https://cdn.learnku.com/uploads/images/201710/14/1/s5ehp11z6s.png?imageView2/1/w/200/h/200',
            'https://cdn.learnku.com/uploads/images/201710/14/1/Lhd1SHqu86.png?imageView2/1/w/200/h/200',
            'https://cdn.learnku.com/uploads/images/201710/14/1/LOnMrqbHJn.png?imageView2/1/w/200/h/200',
            'https://cdn.learnku.com/uploads/images/201710/14/1/xAuDMxteQy.png?imageView2/1/w/200/h/200',
            'https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png?imageView2/1/w/200/h/200',
            'https://cdn.learnku.com/uploads/images/201710/14/1/NDnzMutoxX.png?imageView2/1/w/200/h/200',
        ];
        $cateids = \App\Models\CompanyCategory::where('parent_id', 1)
            ->get()
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
    }

}

