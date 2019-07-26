<?php

use Illuminate\Database\Seeder;
use App\Models\Article;

class ArticlesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = app(\Faker\Generator::class);
        $userids = \App\Models\User::all()->pluck('id')->toArray();
        $articles = factory(Article::class)->times(100)->make()
            ->each(function ($article, $index) use ($userids, $faker) {
                $article->user_id = $faker->randomElement($userids);
                $article->media_type = $faker->randomElement(['video', 'topic', 'audio']);
            if ($article->media_type == 'video') {
                $article->media_url = 'https://unitytouch.oss-cn-shanghai.aliyuncs.com/yhm/production/1.mp4';
            } elseif ($article->media_type == 'audio') {
                $article->media_url = 'https://unitytouch.oss-cn-shanghai.aliyuncs.com/Zzc/Projects/ZhaDaBank/0102121131.mp3';
            } else {
                $article->media_url = '';
            }
            $article->multi_imgs = json_encode($faker->randomElements([
                'https://h5-touch.oss-cn-shanghai.aliyuncs.com/project/abbott/A37.JPG',
                'https://h5-touch.oss-cn-shanghai.aliyuncs.com/project/abbott/a03.JPG',
                'https://h5-touch.oss-cn-shanghai.aliyuncs.com/project/abbott/A25.JPG',
                'https://h5-touch.oss-cn-shanghai.aliyuncs.com/project/abbott/a24.JPG',
                'https://h5-touch.oss-cn-shanghai.aliyuncs.com/project/abbott/a23.JPG'
            ]));
            });

        Article::insert($articles->toArray());

        //添加标签
        $tags = \App\Models\Tag::all()->pluck('id');

        $articles = Article::all();
        foreach ($articles as $article) {
            $article->tags()->attach($faker->randomElements($tags));
        }
    }

}

